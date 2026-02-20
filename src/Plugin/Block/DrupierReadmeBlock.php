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
    $html = <<<'HTML'
<h1>🎨 Drupier theme documentation</h1>
<p>Welcome to the <strong>Drupier</strong> theme! This theme is based on Bootstrap 5, SCSS, and Webpack, with accessibility-first principles. Below you'll find a complete guide to its architecture and usage.</p>
<h2>🗂️ Directory structure</h2>
<pre><code>drupier/
├── assets/
│   ├── css/
│   ├── fonts/
│   ├── icons/
│   ├── img/
├── src/
│   ├── js/
│   ├── scss/
├── templates/
│   ├── ...
├── drupier.info.yml
├── drupier.libraries.yml
├── drupier.theme
├── README.md
</code></pre>
<h2>🧩 SCSS architecture</h2>
<p>SCSS is organized for modularity and scalability:</p>
<pre><code>src/scss/
├── main.scss         # Main entry point
├── base/             # Base styles (fonts, headings, links, tabs, messages)
│   ├── _fonts.scss   # Font imports and variables
│   ├── _headings.scss
│   ├── _links.scss
│   ├── _primary-tabs.scss
│   ├── _system-messages.scss
│   └── index.scss    # Forwards all base modules
├── blocks/           # Block styles
├── field/            # Field styles
├── form/             # Form styles
├── helpers/          # Mixins and utilities
├── node/             # Node styles
├── pages/            # Page-level styles
├── system/           # System styles
├── vars/             # Variables
├── views/            # View styles
</code></pre>
<p><strong>How it works:</strong></p>
<ul>
<li><code>main.scss</code> imports all modules using <code>@use</code>.</li>
<li>Each module is responsible for a specific aspect of the theme.</li>
<li>Fonts are set via CSS variables in <code>_fonts.scss</code>.</li>
</ul>
<p>📊 <strong>SCSS Import Graph:</strong></p>
<pre><code class="language-mermaid">graph TD;
                main.scss --&gt; base;
                main.scss --&gt; blocks;
                main.scss --&gt; field;
                main.scss --&gt; node;
                main.scss --&gt; pages;
                main.scss --&gt; system;
                main.scss --&gt; views;
                base --&gt; _fonts.scss;
                base --&gt; _headings.scss;
                base --&gt; _links.scss;
                base --&gt; _primary-tabs.scss;
                base --&gt; _system-messages.scss;
</code></pre>
<h2>🖥️ JS architecture (Drupal behaviors)</h2>
<p>All JavaScript is placed in <code>src/js/</code> and uses the <a href="https://www.drupal.org/docs/drupal-apis/javascript-api/javascript-api-overview">Drupal Behaviors API</a>.</p>
<p><strong>How it works:</strong></p>
<p><strong>Attaching JS partials/libraries:</strong>
When you create a new JS partial using Drupal behaviors, you must attach the new partial/library to <code>web/themes/custom/drupier/drupier.libraries.yml</code>. You can attach it locally (for specific blocks or components) or globally (for the entire platform).</p>
<p><strong>Example (add a new JS file globally):</strong></p>
<pre><code class="language-yaml">global-scripts:
  js:
    assets/js/my-new-script.js: {}
  dependencies:
    - core/jquery
</code></pre>
<p>Then, add <code>drupier/global-scripts</code> to your theme's <code>.info.yml</code> or attach it to a block/component as needed.</p>
<p><strong>Example:</strong></p>
<pre><code class="language-js">(function (Drupal, $, once) {
  'use strict';
  Drupal.behaviors.exampleBehavior = {
    attach: function (context, settings) {
      once('example-behavior', '.my-selector', context).forEach(function (
        element
      ) {
        // Your code here
      });
    },
  };
})(Drupal, jQuery, once);
</code></pre>
<p>🧠 <strong>Tip:</strong> Always use a unique string for <code>once()</code> and a specific selector.</p>
<h2>🔤 Fonts</h2>
<p>Fonts are stored in <code>assets/fonts/</code> and loaded via SCSS. The theme uses <a href="https://fontsource.org/docs/getting-started/webfont-loader">Fontsource</a> to manage font families, such as Poppins (weights 100-900), but you can install and use any font family following the Fontsource installation guide.</p>
<p><strong>How it works:</strong></p>
<ul>
<li>Install the desired font family using npm/yarn, e.g. <code>npm install @fontsource/poppins</code>.</li>
<li>Import the font weights you need in your SCSS, e.g. <code>@import '@fontsource/poppins/400.css';</code>.</li>
<li>Set CSS variables for font families in your SCSS (see below), or use the <code>@mixin font</code> from <code>src/scss/helpers/_mixins.scss</code> for consistent font styling.</li>
<li>All font files are stored in <code>assets/fonts/</code> for local usage and performance.</li>
</ul>
<p><strong>Using the font mixin:</strong></p>
<p>First, import the globals and mixins at the top of your SCSS partials:</p>
<pre><code class="language-scss">@use '../globals' as *;
</code></pre>
<p>After that, you have the <code>font</code> mixin available to use like this:</p>
<pre><code class="language-scss">.headline {
  @include font(32, 700, &quot;'Poppins', sans-serif&quot;, 0.5, 1.2);
}
</code></pre>
<p>This mixin lets you set font size, weight, family, letter-spacing, and line-height easily and consistently across your theme. Adjust the parameters as needed for your design.</p>
<p>If you have doubts about how to install or use Fontsource, please refer to the official guide or visit this help post: <a href="https://intranet.tothomweb.com/node/207">How to use Fontsource in Drupier</a></p>
<h2>🖼️ Images</h2>
<p>Images should be stored in <code>src/img/</code> and can be referenced in your SCSS files for backgrounds and other uses.</p>
<p><strong>How to use images in SCSS as backgrounds:</strong></p>
<ul>
<li>The theme uses the <code>@img</code> alias to simplify referencing images in SCSS. This alias points to the <code>src/img/</code> directory.</li>
<li>To use an image as a background, simply use:</li>
</ul>
<pre><code class="language-scss">.hero {
  background-image: url('@img/marco-grosso-wM3YUeiff44-unsplash.jpg');
  background-size: cover;
  background-position: center;
}
</code></pre>
<p><strong>Explanation:</strong></p>
<ul>
<li><code>@img</code> is resolved by Webpack to the correct path for your images, so you don't need to worry about relative paths.</li>
<li>This makes your SCSS cleaner and ensures images are correctly bundled and optimized.</li>
<li>You can use any image from the <code>src/img/</code> directory by referencing its filename after the <code>@img/</code> alias.</li>
</ul>
<p><strong>Tips:</strong></p>
<ul>
<li>Always use descriptive filenames for your images.</li>
<li>Use <code>background-size: cover;</code> and <code>background-position: center;</code> for responsive backgrounds.</li>
<li>If you add new images, re-run your build process to ensure they are included.</li>
</ul>
<h2>🏷️ Icons</h2>
<p>Icons are stored in <code>assets/icons/</code>:</p>
<ul>
<li>Uses Bootstrap Icons (<code>bootstrap-icons.woff</code>, <code>.woff2</code>).</li>
<li>Reference icons in CSS or via <code>&lt;i class=&quot;bi bi-icon-name&quot;&gt;&lt;/i&gt;</code> in templates.</li>
</ul>
<blockquote>
<p><strong>Note:</strong> Bootstrap Icons are optional in this theme. If you find the icon set too large or unnecessary for your project, you can safely uninstall or remove Bootstrap Icons from your theme assets and configuration.</p>
</blockquote>
<p><strong>Using icons as a font-family in CSS:</strong></p>
<p>You can also use Bootstrap Icons as a regular font-family in your SCSS, allowing you to display icons using pseudo-elements and Unicode values.</p>
<p><strong>Example:</strong></p>
<pre><code class="language-scss">.view-empty {
  font-size: 2rem;
  &amp;::before {
    font-family: 'bootstrap-icons';
    font-weight: 400;
    font-size: 25px;
    content: '\\F3EE'; // Unicode for the desired icon
    display: block;
    margin-top: 1rem;
  }
}
</code></pre>
<p><strong>Explanation:</strong></p>
<ul>
<li>Set <code>font-family: 'bootstrap-icons'</code> to use the icon font.</li>
<li>Use the correct Unicode value for the icon you want to display (see the <a href="https://icons.getbootstrap.com/">Bootstrap Icons cheatsheet</a>).</li>
<li>This method is useful for adding icons via CSS, especially in pseudo-elements like <code>::before</code> or <code>::after</code>.</li>
</ul>
<h2>📝 Templates</h2>
<p>Templates are stored in <code>templates/</code> and organized by entity type (block, field, menu, node, page, view, etc.).</p>
<ul>
<li>Use Twig for custom markup and logic.</li>
<li>Extend or override templates as needed for your site.</li>
</ul>
<h2>⚙️ Theme settings</h2>
<p>Theme settings are managed in <code>drupier.theme</code> using hooks to alter options (e.g., navbar background).</p>
<h2>🌐 DDEV browsersync</h2>
<p>DDEV BrowserSync provides live-reloading and synchronized browser testing for your theme development. It automatically refreshes your browser when you change SCSS, JS, or template files, speeding up your workflow.</p>
<p><strong>How it works:</strong></p>
<ul>
<li>Watches your theme files for changes and reloads the browser instantly.</li>
<li>Works with multiple devices and browsers at once for synchronized testing.</li>
</ul>
<p><strong>How to install:</strong>
Make sure the <code>ddev/ddev-browsersync</code> add-on is already available for this project.</p>
<pre><code class="language-bash">ddev add-on get ddev/ddev-browsersync
ddev restart
</code></pre>
<blockquote>
<p><strong>Note:</strong> Avoid installing while connected to a VPN or Cloudflare WARP, otherwise the download may fail.</p>
</blockquote>
<p><strong>Usage:</strong></p>
<ol>
<li>From the theme root, launch the asset watcher:</li>
</ol>
<pre><code class="language-bash">npm run dev
</code></pre>
<ol start="2">
<li>In a second terminal (also in the theme root) start BrowserSync:</li>
</ol>
<pre><code class="language-bash">ddev browsersync web/themes/custom/drupier
</code></pre>
<p>or run this alias if you already added it to your <code>.zshrc</code> as explained below.</p>
<pre><code class="language-bash">brw
</code></pre>
<ol start="3">
<li>Disable CSS/JS aggregation at <code>/admin/config/development/performance</code> so changes appear immediately.</li>
<li>Enable all development settings at <code>/admin/config/development/settings</code> to keep debugging tools active.</li>
<li>Leave both terminals running—<code>npm run dev</code> continually rebuilds assets while BrowserSync (or the <code>brw</code> alias) provides live reloads.</li>
<li>BrowserSync outputs a preview link such as <code>https://example.ddev.site:3000</code>. If you configured <code>additional_hostnames</code> in <code>.ddev/config.yaml</code>, you can also access the site via your custom url like <code>https://example.local:3000</code>.</li>
</ol>
<p><strong>Pro tip:</strong>
You can add an alias to your <code>.zshrc</code> for faster access:</p>
<pre><code class="language-bash">alias brw='ddev browsersync web/themes/custom/drupier'
</code></pre>
<p>After adding the alias, simply run <code>brw</code> from your project root to start BrowserSync.</p>
<p><strong>Example output when you run <code>brw</code>:</strong></p>
<pre><code>Proxying Browsersync on https://drupier.ddev.site:3000
[Browsersync] Proxying: http://drupier.ddev.site
</code></pre>
<p>This means BrowserSync is running on port 3000 and is proxying your DDEV site. You can open <code>https://drupier.ddev.site:3000</code> in your browser for live-reloading and synchronized testing. All changes to your theme files will automatically refresh the browser.</p>
<h2>🚀 Getting started</h2>
<ol>
<li>Customize SCSS, JS, fonts, icons, and templates as needed.</li>
<li>Run Webpack to build assets if you make changes. In the theme root, use:</li>
</ol>
<pre><code class="language-bash">npm run dev
</code></pre>
<p>This will start Webpack in watch mode for development and automatically rebuild assets when you make changes.</p>
<h2>📚 Resources</h2>
<ul>
<li><a href="https://www.drupal.org/docs/theming-drupal">Drupal Theme Guide</a></li>
<li><a href="https://www.drupal.org/project/bootstrap_barrio">Bootstrap Barrio</a></li>
<li><a href="https://fontsource.org/">Fontsource</a></li>
<li><a href="https://icons.getbootstrap.com/">Bootstrap Icons</a></li>
</ul>
<p>Enjoy building with Drupier! ✨</p>
<h2>📜 License</h2>
<p>This theme is proprietary software developed for <a href="https://tothomweb.com/">Tothom</a>. Reuse or modification requires permission from the maintainers.</p>
<p><em>Maintained by <a href="https://tothomweb.com/">Tothom</a> Development Team</em> - <a href="https://www.linkedin.com/in/webfer/">Fernando Castro</a> &amp; <a href="https://www.linkedin.com/in/jgaltes/">Joan Galtés</a></p>
HTML;

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
