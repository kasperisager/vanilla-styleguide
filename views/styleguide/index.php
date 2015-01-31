<?php if (!defined('APPLICATION')) exit;

include_once 'helper_functions.php';

$overview = $this->data('overview');
$section = $this->data('section');
$children = $this->data('children');
?>

<?php if ($overview): ?>
  <aside class="styleguide-sidebar" role="complementary">
    <nav class="styleguide-overview">
      <?php foreach ($overview as $item) {
        $path = 'vanilla/styleguide';

        if ($item->getSection() !== '0') {
          $path .= '/' . $item->getSection();
        }

        $text = $item->getSection() . '. ' . $item->getTitle();

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

    <?php foreach ($children as $child) {
      echo styleguideBlock($child);
    } ?>
  </main>
<?php endif ?>
