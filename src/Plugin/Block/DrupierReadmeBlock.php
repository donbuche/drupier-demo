<?php

namespace Drupal\drupier_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Render\Markup;
use Drupal\Component\Utility\Html;
use League\CommonMark\CommonMarkConverter;

/**
 * Provides a block that renders the Drupier theme README.
 *
 * @Block(
 *   id = "drupier_demo_readme_block",
 *   admin_label = @Translation("Drupier README"),
 *   category = @Translation("Drupier Demo")
 * )
 */
class DrupierReadmeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $theme_path = \Drupal::service('extension.list.theme')->getPath('drupier');
    $readme_path = DRUPAL_ROOT . '/' . $theme_path . '/README.md';

    if (!is_file($readme_path)) {
      return [
        '#markup' => $this->t('README.md not found.'),
        '#cache' => ['max-age' => 0],
      ];
    }

    $markdown = file_get_contents($readme_path);
    $html = '';

    try {
      $converter = new CommonMarkConverter();
      $html = $converter->convertToHtml($markdown);
    }
    catch (\Throwable $e) {
      \Drupal::logger('drupier_demo')->error('Markdown conversion failed: @message', ['@message' => $e->getMessage()]);
      \Drupal::logger('drupier_demo')->error('CommonMarkConverter class exists: @exists', [
        '@exists' => class_exists(CommonMarkConverter::class) ? 'yes' : 'no',
      ]);
      if (\Drupal::hasService('markdown')) {
        $html = \Drupal::service('markdown')->transform($markdown);
      }
      else {
        // Fallback: render as plain text with line breaks.
        $html = nl2br(Html::escape($markdown));
        \Drupal::logger('drupier_demo')->warning('Markdown converter not available; rendering README.md as plain text.');
      }
    }

    $build = [
      '#markup' => Markup::create($html),
    ];

    // Disable cache to reflect README changes immediately.
    $cacheability = new CacheableMetadata();
    $cacheability->setCacheMaxAge(0);
    $cacheability->applyTo($build);

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags(): array {
    return Cache::mergeTags(parent::getCacheTags(), ['theme:drupier']);
  }

}
