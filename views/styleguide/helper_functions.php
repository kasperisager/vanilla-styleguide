<?php if (!defined('APPLICATION')) exit;

if (!function_exists('styleguideBlock')):
  /**
   * Render a KSS section block
   *
   * @since 1.0.0
   * @param $section The section to render
   */
  function styleguideBlock($section) {
    ?>
    <div class="styleguide-block" id="r<?php echo $section->getReference(); ?>">
      <h3 class="styleguide-header">
        <span class="styleguide-reference"><?php echo $section->getReference(); ?></span>
        <span class="styleguide-title"><?php echo $section->getTitle(); ?></span>
        <span class="styleguide-filename"><?php echo $section->getFilename(); ?></span>
      </h3>

      <div class="styleguide-description">
        <?php echo Gdn_Format::Markdown($section->getDescription()); ?>

        <?php if (count($section->getModifiers()) > 0): ?>
          <ul class="styleguide-modifiers">
            <?php foreach ($section->getModifiers() as $modifier): ?>
              <li>
                <span class="styleguide-modifier-name<?php echo ($modifier->isExtender()) ? ' styleguide-modifier-name-extender' : ' '; ?>"><?php echo $modifier->getName(); ?></span>
                <?php if ($modifier->isExtender()): ?>
                  @extend
                  <span class="styleguide-modifier-name"><?php echo $modifier->getExtendedClass(); ?></span>
                <?php endif; ?>

                <?php if ($modifier->getDescription()): ?>
                  - <?php echo Gdn_Format::Markdown($modifier->getDescription()); ?>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <div class="styleguide-elements">
          <div class="styleguide-element">
            <?php echo $section->getMarkupNormal(); ?>
          </div>

          <?php foreach ($section->getModifiers() as $modifier): ?>
            <div class="styleguide-element styleguide-element-modifier<?php ($modifier->isExtender()) ? ' styleguide-element-extender' : ' '; ?>">
              <span class="styleguide-element-modifier-label<?php echo ($modifier->isExtender()) ? ' styleguide-element-modifier-label-extender' : ' '; ?>"><?php echo $modifier->getName(); ?></span>
              <?php echo $modifier->getExampleHtml(); ?>
            </div>
          <?php endforeach; ?>
      </div>

      <div class="styleguide-html">
        <?php
        $highlighter = new \FSHL\Highlighter(new \FSHL\Output\Html());
        $highlighter->setLexer(new \FSHL\Lexer\Html());
        ?>
        <pre class="styleguide-code"><code><?php echo $highlighter->highlight($section->getMarkupNormal('{class}')); ?></code></pre>
      </div>
    </div>
    <?php
  }
endif;
