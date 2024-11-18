<?php include("menu/link_css.php");?>

<body>
    
<div class="container-xxl bg-white p-0">
        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <?php include("menu/navbar.php");?>
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-4 text-white mb-3 animated slideInDown">Réservez votre table en un clic</h1>
                <p class="text-white-50 animated slideInUp">Profitez d'une expérience culinaire exceptionnelle dans un cadre élégant.</p>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                            
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        </div>


        <?php include 'process_send_reservation.php'; ?>
        <div class="container-xxl py-5 px-0 wow fandInUp" data-wow-delay="0.1s">
            <div class="col-md-12 col-sm-12 mb-3">
            <?php if (!empty($erreur)): ?>
            <div id="error-message" class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div id="success-message" class="alert alert-success text-center" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 p-3">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 mb-3">
                    <div class="video">
                        <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-3 bg-dark">
                        <div class="mb-3">
                            <h5 class="section-title ff-secondary text-start text-primary fw-normal">Réservation</h5>
                            <h1 class="text-white mb-4">Réservez une table en ligne</h1>
                        </div>
                        <div class="mb-3">
                        <form action="" method="POST">
                                <div class="row g-3 col-sm-12 p-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control shadow-none border-none" name="customer_name" id="name" placeholder="Votre nom">
                                            <label for="name">Votre nom</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['customer_name'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control shadow-none border-none" name="customer_email" id="email" placeholder="Votre email">
                                            <label for="email">Votre email</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['customer_email'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control shadow-none border-none" name="customer_phone" id="phone" placeholder="Votre téléphone">
                                            <label for="phone">Votre téléphone</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['customer_phone'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date">
                                            <input type="datetime-local" class="form-control shadow-none border-none" name="reservation_date" id="datetime" placeholder="Date & Heure">
                                            <label for="datetime">Date & Heure</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['reservation_date'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <select class="form-select shadow-none border-0" name="number_of_people" id="select1">
                                                <option value="1">1 personne</option>
                                                <option value="2">2 personnes</option>
                                                <option value="3">3 personnes</option>
                                                <option value="4">4 personnes</option>
                                                <option value="5">5 personnes</option>
                                                <option value="6">6 personnes</option>
                                                <option value="7">7 personnes</option>
                                                <option value="8">8 personnes</option>
                                            </select>
                                            <label for="select1">Nombre de personnes</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['number_of_people'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control shadow-none border-none" name="special_request" id="message" placeholder="Demande spéciale" style="height: 100px"></textarea>
                                            <label for="message">Demande spéciale</label>
                                        </div>
                                        <?php if (isset($erreur_champ) && empty($_POST['special_request'])): ?>
                                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12">
                                        <button name="submit" class="btn btn-primary w-100 py-3 shadow-none border-none" type="submit">Réserver maintenant</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
<!-- Team End -->
<?php include_once("menu/footer.php");?>
        <!-- Footer End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top shadow-none"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>






