<?php 
  $changelog = $displayData['changelog'];

  $issues = [];

  $groupTitles = [
    'Bug' => 'Bug Fix',
    'Task' => 'Update'
  ];
?>

<?php if (!empty($changelog)) : ?>
<div class="modal fade" id="tplChangelogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myLargeModalLabel">Changelogs</h4>
      </div>
      <div class="modal-body">
        <section id="pd-changelogs" class="pd-changelog">
          <div class="changelogs-wrap">
            <div class="changelogs">
              <?php foreach ($changelog as $version => $log) : ?>
              <div class="changelog-version">
                <h4><span class="version">Version <?php echo $log['version'] ?></span><span class="date"><?php echo date('d M, Y', strtotime($log['date'])) ?></span></h4>
                  <?php 
                  if ($log['version'] == '1.0.0') {
                    echo '<span class="changelog-note">First release</span>';
                    break;
                  }

                  $group = null;
                  foreach ($log['issues'] as $issue) : 
                    if ($issue['type'] != $group) {
                      if ($group) echo '</ul></div>';
                      $group = $issue['type'];
                      echo '<div class="changelog-type type-' . str_replace(' ', '-', strtolower($group)) . '">';
                      echo '<span class="issue-type-title">' . (!empty($groupTitles[$group]) ? $groupTitles[$group] : $group) . '</span>';
                      echo '<ul class="changelog-issues">';
                    }
                    ?>
                  <li>
                      <?php echo "{$issue['issue']}" ?>
                  </li>
                  <?php endforeach;
                  if ($group) echo '</ul></div>';
                  ?>
              </div>
              <?php endforeach ?>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
