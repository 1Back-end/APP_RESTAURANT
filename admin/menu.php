<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h6 class="text-uppercase">Liste des menus</h6>
            </div>
            <div class="ml-auto">
                <a href="add_menu.php" class="btn btn-customize text-white text-uppercase">
                <i class="fa fa-plus mr-1 fw-bold" aria-hidden="true"></i>
                    Ajouter
                </a>
            </div>
        </div>
        </div>
    </div>






<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
        <?php
include_once("../database/connexion.php"); // Inclure la connexion PDO

// Récupérer les menus
$menus = recupererMenus($connexion);
?>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du Menu</th>
                    <th>Lien du Menu</th>
                    <th>Ordre de Tri</th>
                    <th>Actif</th>
                    <th>Ajouté le</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $index => $menu): ?>
                        <tr>
                            <td><?php echo ($index + 1); ?></td>
                            <td><?= htmlspecialchars($menu['menu_label']) ?></td>
                            <td>
                                <a href="../<?= htmlspecialchars($menu['menu_link']) ?>" target="_blank"><?= htmlspecialchars($menu['menu_link']) ?></a>
                            </td>

                            <td><?= htmlspecialchars($menu['sort_order']) ?></td>
                            <td>
                                <?php if ($menu['is_active']): ?>
                                    <span class="badge bg-success text-center text-white">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger text-center text-white">Inactif</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars((new DateTime($menu['created_at']))->format('d/m/Y H:i'))?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucun menu trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
  

        </div>
    </div>
</div>
</div>

