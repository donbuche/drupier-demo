<?php

namespace Drupal\drupier_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Drupier Demo marquee block.
 *
 * @Block(
 *   id = "drupier_demo_marquee_example_block",
 *   admin_label = @Translation("Drupier Demo Marquee"),
 *   category = @Translation("Drupier Demo")
 * )
 */
class MarqueeExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#markup' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora sint vitae alias! Alias sequi ipsam animi deleniti nulla numquam earum in, dignissimos, ipsum.</p>',
    ];
  }

}
