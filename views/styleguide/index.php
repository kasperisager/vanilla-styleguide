<?php if (!defined('APPLICATION')) exit;

include_once 'helper_functions.php';

$overview = $this->data('overview');
$section = $this->data('section');
$children = $this->data('children');

$highlighter = new \FSHL\Highlighter(new \FSHL\Output\Html());
$highlighter->setLexer(new \FSHL\Lexer\Html());
?>

<?php if ($overview): ?>
  <aside class="styleguide-sidebar" role="complementary">
    <nav class="styleguide-overview">
      <?php foreach ($overview as $item) {
        $path = 'vanilla/styleguide';

        if ($item->getReference() !== '0') {
          $path .= '/' . $item->getReference();
        }

        $text = $item->getReference() . '. ' . $item->getTitle();

        echo Gdn_Theme::Link($path, $text);
      } ?>
    </nav>
  </aside>
<?php endif ?>

<?php if ($section): ?>
  <main class="styleguide-content" role="main">
    <h2 class="styleguide-section-header">
      <?php echo $section->getTitle() ?>
    </h2>

    <div class="styleguide-section-description">
      <?php echo Gdn_Format::Markdown($section->getDescription()); ?>
    </div>

    <?php foreach ($children as $child): ?>
      <div class="styleguide-block" id="r<?php echo $child->getReference(); ?>">
        <h3 class="styleguide-header">
          <span class="styleguide-reference"><?php echo $child->getReference(); ?></span>
          <span class="styleguide-title"><?php echo $child->getTitle(); ?></span>
          <span class="styleguide-filename"><?php echo $child->getFilename(); ?></span>
        </h3>

        <?php if ($child->getDeprecated()): ?>
          <div class="styleguide-status styleguide-status-deprecated">
            <div class="styleguide-status-content">
              <div class="styleguide-status-label">
                <?php echo t("Deprecated"); ?>
              </div>

              <div class="styleguide-status-description">
                <?php echo Gdn_Format::Markdown($child->getDeprecated()); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($child->getExperimental()): ?>
          <div class="styleguide-status styleguide-status-experimental">
            <div class="styleguide-status-content">
              <div class="styleguide-status-label">
                <?php echo t("Experimental"); ?>
              </div>

              <div class="styleguide-status-description">
                <?php echo Gdn_Format::Markdown($child->getExperimental()); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="styleguide-description">
          <?php echo Gdn_Format::Markdown($child->getDescription()); ?>

          <?php if (count($child->getModifiers()) > 0): ?>
            <ul class="styleguide-modifiers">
              <?php foreach ($child->getModifiers() as $modifier): ?>
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
              <?php echo $child->getMarkupNormal(); ?>
            </div>

            <?php foreach ($child->getModifiers() as $modifier): ?>
              <div class="styleguide-element styleguide-element-modifier<?php ($modifier->isExtender()) ? ' styleguide-element-extender' : ' '; ?>">
                <span class="styleguide-element-modifier-label<?php echo ($modifier->isExtender()) ? ' styleguide-element-modifier-label-extender' : ' '; ?>"><?php echo $modifier->getName(); ?></span>
                <?php echo $modifier->getExampleHtml(); ?>
              </div>
            <?php endforeach; ?>
        </div>

        <div class="styleguide-html">
          <pre class="styleguide-code"><code><?php echo $highlighter->highlight($child->getMarkupNormal('{class}')); ?></code></pre>
        </div>
      </div>
    <?php endforeach; ?>
  </main>
<?php endif ?>
