<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h5 class="text-uppercase">Liste des utilisateurs</h5>
                </div>
                <div class="ml-auto">
                    <a href="ajouter_utilisateur.php" class="btn btn-customize border-0 text-white text-uppercase">
                        Ajouter
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
    <?php if (!empty($_GET["msg"])): ?>
        <?php $msg = htmlspecialchars($_GET["msg"], ENT_QUOTES, 'UTF-8'); ?>
        <?php if (!empty($msg)): ?>
            <div id="alertMsg" class="alert alert-success alert-dismissible text-center">
                <?= $msg; ?>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    setTimeout(function() {
                        var alertMsg = document.getElementById("alertMsg");
                        if (alertMsg) {
                            alertMsg.style.display = "none";
                        }
                    }, 2000);
                });
            </script>
        <?php endif; ?>
    <?php endif; ?>
</div>

    <div class="col-md-12 col-sm-12 mb-3">
            <div class="card-box p-3">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                    <th>#</th>
                    <th>Nom Complet</th>
                    <th>Adresse</th>
                    <th>Contact</th>
                    <th>Statut</th>
                    <th>Ajouté le</th>
                    <th>Actions</th>
                    </thead>
                <tbody>
                    <?php if(empty($all_users)):?>
                    <tr>
                         <td colspan="10">Aucun utilisateur trouvé</td>
                    </tr>
                    <?php else :?>
                        <?php foreach ($all_users as $index => $user):?>
                           <tr>
                           <td><?php $index + 1?></td>
                           <td class="text-nowrap" style="max-width: 200px; overflow: hidden;">
                                <div class="d-flex align-items-center">
                                    <?php if (!empty($user['photo'])) : ?>
                                    <img src="../uploads/<?= $user['photo'] ?>" class='rounded-circle img-fluid me-2' width='50' height='50' style='object-fit: cover; width: 50px; height: 50px; max-width: 50px; max-height: 50px;'>
                                    <?php else : ?>
                                                <img src="https://i.pinimg.com/564x/07/01/e5/0701e5a1cd4f91681f76cf3691176680.jpg" class='rounded-circle img-fluid me-2' width='50' height='50' style='object-fit: cover; width: 50px; height: 50px; max-width: 50px; max-height: 50px;'>
                                    <?php endif; ?>
                                    <div class="ms-3">
                                    <span class="mx-2 text-truncate" style="max-width: calc(100% - 50px);"><?= htmlspecialchars($user["email"]) ?></span>
                                </div>
                                </div>
                            </td>
                            <!-- <td><?= htmlspecialchars($user["email"]) ?></td> -->
                            <td><?= htmlspecialchars($user["address"]) ?></td>
                            <td><?= htmlspecialchars($user["phone_number"])?></td>
                            <td>
                                <?php if ($user["is_active"] == 1):?>
                                    <span class="disabled btn btn-success btn-sm btn-xs text-white btn-rounded">Actif</span>
                                <?php else:?>
                                    <span class="disabled btn btn-danger btn-sm btn-xs text-white btn-rounded">Inactif</span>
                                <?php endif;?>

                            </td>
                            <td><?= date('d-m-Y H:i:s',strtotime(htmlspecialchars($user['created_at']))) ?></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="process_delete_user.php?user_uuid=<?= htmlspecialchars($user["admin_uuid"]) ?>" class="btn btn-xs btn-sm btn-danger mx-2">Supprimer</a>
                                    <?php if ($user["is_active"] ==1):?>
                                        <a href="process_update_status_user.php?user_uuid=<?= htmlspecialchars($user["admin_uuid"]) ?>" class="btn-info btn-xs btn-sm shadow-none border-0 mx-2">
                                            Désactiver
                                        </a>
                                    <?php else :?>
                                        <a href="" class="btn-success btn-xs btn-sm shadow-none border-0 mx-2">
                                            Activer
                                        </a>
                                    <?php endif;?>
                                </div>
                            </td>
                           </tr>
                      <?php endforeach; ?>
                      <?php endif; ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>