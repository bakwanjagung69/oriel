<!-- Breadcrumbs-->
<?php 
  $uri_segments = explode("/", $_SERVER['REQUEST_URI']);
  // print_r($uri_segments);die;  
  $index   = (count($uri_segments) - 1);
  $uriText = '';
  if ($index >= 3) {
    // $uriText = ($uri_segments[($index - 1)] == 'admin' ? 'Dashboard' : $uri_segments[($index - 2)].' '.$uri_segments[($index - 1)]);
    $uriText = ($uri_segments[($index)] == 'admin' ? 'Dashboard' : $uri_segments[($index)]);
  } else {
    $uriText = ($uri_segments[$index] == 'admin' ? 'Dashboard' : $uri_segments[$index]); 
  }

  $uriText = preg_replace('/(?<!\ )[A-Z][a-z]/', ' $0', $uriText);
  $uriText = (strlen($uriText) >= 12 ? substr($uriText,0,12).'...' : $uriText);
?>
<section class="content-header">
  <h1>
    <?= strtok(ucfirst($uriText), '?'); ?>
    <small>Pages</small>
  </h1>
  <ol class="breadcrumb">
    <?php 
      for ($i=1; $i < count($uri_segments); $i++) { 
      $urlSegment = ($uri_segments[$i] == 'admin') ? 'Home' : $uri_segments[$i]; 
      $urlSegment = preg_replace('/(?<!\ )[A-Z][a-z]/', ' $0', $urlSegment);      
      $urlSegment = (strlen($urlSegment) >= 12 ? substr($urlSegment,0,12).'...' : $urlSegment);
    ?>
      <?php if ($i !== 1) { ?>
        <li class="active">
          <?php
            switch ($i) {
              case 2:
                echo '<a href="'.site_url($uri_segments[$i - 1].'/'.$uri_segments[$i]).'">'.strtok(ucfirst($urlSegment), '?').'
                  </a>';
            break;
            case 3:
                echo '<a href="'.site_url($uri_segments[$i - 2].'/'.$uri_segments[$i - 1].'/'.$uri_segments[$i]).'">'.strtok(ucfirst($urlSegment), '?').'
                  </a>';
            break;
              default:
                echo strtok(ucfirst($urlSegment), '?');
            break;
            }
          ?>
        </li> 
      <?php } else { ?>
        <li class="active">
            <a href="<?php echo site_url($uri_segments[$i]); ?>">
              <i class="fa fa-dashboard"></i>
              <?= strtok(ucfirst($urlSegment), '?'); ?>
            </a>
        </li>
      <?php } ?>
  <?php } ?>
  </ol>
</section>