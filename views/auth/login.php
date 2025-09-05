<?php
userAlreadyConnect();

$title = "Se connecter";

require BASE_VIEW_PATH . '/inc/header.php';

?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php require BASE_VIEW_PATH . '/inc/flash.php'; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Connexion</h5>
                </div>

                <div class="card-body">
                    <form method="post" action="<?= route('auth.store') ?>">

                        <div class="mb-3">
                            <?= input('username', 'text', '', 'Nom d\'utilisateur') ?>
                        </div>

                        <div class="mb-3">
                            <?= input('password', 'password', '', 'Mot de passe') ?>
                        </div>


                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn btn-primary">
                                Se connecter
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>
