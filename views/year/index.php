<?php 
require BASE_VIEW_PATH . '/inc/header.php';
require BASE_PATH .'/queries/year.php';

$years = findYears();

?>
<div class="container py-5">
    <h2>Gestion des années scolaires</h2>

    <?php require BASE_VIEW_PATH . '/inc/flash.php' ?>

    <table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>Début</th>
      <th>Fin</th>
      <th>Status</th>
      <th>Création</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($years as $year): ?>
    <tr>
      <td><?= $year['id'] ?></td>
      <td><?= $year['start'] ?></td>
      <td><?= $year['end'] ?></td>
      <td><?= $year['is_closed'] == 0 ? 'en cours' : 'cloturée' ?></td>
      <td> <?= ago($year['creeated_at'] ?? new DateTime()) ?></td>
      <td> 

        <?php if ($year['is_closed'] === 0): ?>
        <form method="post" style="display: inline-block;" action="<?= route('year.closed', ['id' => $year['id']]) ?>" onsubmit="return confirm('Voulez-vous vraiment effectuer cette action ?')"">
          <button  href="/year/<?=  $year['id'] ?>/show" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                </svg>
                Cloturer
            </button>
        </form>
        <?php endif ?>

        <a href="<?= route('year.show', ['id' => $year['id']]) ?>" class="btn btn-light btn-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
          </svg>
            Voir
        </a>

        <form method="post" style="display: inline-block;" action="<?= route('year.destroy', ['id' => $year['id']]) ?>" onsubmit="return confirm('Voulez-vous vraiment effectuer cette action ?')"">
          <button  href="/year/<?=  $year['id'] ?>/show" class="btn btn-danger btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                </svg>
                Supprimer
            </button>
        </form>
       
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php require BASE_VIEW_PATH . '/inc/footer.php' ?>