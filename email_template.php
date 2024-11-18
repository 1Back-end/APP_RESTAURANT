<?php
function getEmailTemplate($customerName, $customerEmail, $customerPhone, $reservationDate, $numberOfPeople, $specialRequest) {
    return "
        <h1>Nouvelle réservation</h1>
        <p><strong>Nom :</strong> $customerName</p>
        <p><strong>Email :</strong> $customerEmail</p>
        <p><strong>Téléphone :</strong> $customerPhone</p>
        <p><strong>Date et heure :</strong> $reservationDate</p>
        <p><strong>Nombre de personnes :</strong> $numberOfPeople</p>
        <p><strong>Demande spéciale :</strong> $specialRequest</p>
    ";
}
?>
