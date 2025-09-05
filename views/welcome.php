<?php require BASE_VIEW_PATH . '/inc/header.php'; ?>

<div class="container py-5">
    <!-- Hero Section -->
    <div class="row align-items-center py-5">
        <div class="col-lg-8 mx-auto text-center">
            <!-- Icône ou illustration -->
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-mortarboard-fill text-primary" viewBox="0 0 16 16">
                    <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
                    <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
                </svg>
            </div>
            
            <!-- Titre principal -->
            <h1 class="display-5 fw-bold mb-3">Application de Délibération</h1>
            
            <!-- Description de l'application -->
            <p class="lead mb-4">
                Solution complète développée pour la gestion des délibérations scolaires. 
                Gérez les étudiants, les notes, les statistiques et les processus de délibération 
                de manière simple et efficace.
            </p>
            
            <!-- Indication pour l'utilisateur -->
            <div class="alert alert-light border mt-4" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-compass me-2" viewBox="0 0 16 16">
                    <path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016zm6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                    <path d="M6.94 7.44l4.95-2.83-2.83 4.95-4.949 2.83 2.828-4.95z"/>
                </svg>
                Utilisez le menu de navigation pour accéder aux différentes sections de l'application.
            </div>
            
            <!-- Cartes de fonctionnalités -->
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-people-fill text-primary mb-3" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                            <h5 class="card-title">Gestion des Étudiants</h5>
                            <p class="card-text small">Gestion complète des étudiants</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-clipboard-data-fill text-primary mb-3" viewBox="0 0 16 16">
                                <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <h5 class="card-title">Saisie des Notes</h5>
                            <p class="card-text small">Saisie et gestion simplifiée des résultats académiques</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-graph-up-arrow text-primary mb-3" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
                            </svg>
                            <h5 class="card-title">Statistiques & Rapports</h5>
                            <p class="card-text small">Analyse détaillée et génération de rapports complets</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Information académique -->
            <div class="mt-5 pt-4 border-top">
                <p class="text-muted small">
                    Développé dans le cadre d'un travail académique - 
                    <span class="fst-italic">Solution professionnelle pour établissements scolaires</span>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require BASE_VIEW_PATH . '/inc/footer.php'; ?>