<?php

require_once 'connect.php';



require_once './templates/header.php';
?>
<section class="row-limit-size section-padding">
    <form action="#" method="GET" class="form-envoie-resa">
        <?php 
        if(isset($_GET['id'])){
        ?>
            <input type="hidden" name="id_gite" value="<?= $_GET['id'] ?>">
        <?php } ?>
        <div class="flex-btw">
            <label for="firstname_client" class="label-form-filter">PRENOM</label>
            <input type="text" class="input-resa" name="firstname_client" id="firstname_client">
        </div>
        <br>
        <div class="flex-btw">
            <label for="lastname_client" class="label-form-filter">NOM</label>
            <input type="text" name="lastname_client" id="lastname_client" class="input-resa">
        </div>
        <br>
        <div class="flex-btw">
            <label for="mail_client" class="label-form-filter">E-MAIL</label>
            <input type="email" size="30" placeholder="xxxxx@gmail.com" name="mail_client" id="mail_client" class="input-resa">
        </div>
        <br>
        <div class="flex-btw">
            <label for="phone_client" class="label-form-filter">TÉLÉPHONE</label>
            <input type="tel" name="phone_client" id="phone_client" class="input-resa" placeholder="06 00 00 00 00">
        </div>
        <br>
        <div class="flex-btw">
            <label for="nbr_traveller" class="label-form-filter">NOMBRE DE VOYAGEUR</label>
            <input type="number" min="1" name="nbr_traveller" id="nbr_traveller" class="input-resa nb-resa">
        </div>
        <br>
        <div class="flex-btw">
            <label for="" class="label-form-filter">DATE DE RESERVATION</label> <br>
        </div>
        <div class="flex-btw around">
            <label for="start_date_reserv"" class=" label-form-filter">ARRIVÉE</label>
            <input type="date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" class="date-input-resa" name="start_date_reserv" id="start_date_reserv">

            <label for="end_date_reserv" class="label-form-filter">DÉPART</label>
            <input type="date" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>" class="date-input-resa" name="end_date_reserv" id="end_date_reserv">
        </div>
        <br><br>
        <button class="btn-util btn-filtrer" type="submit" name="submit">Valider</button>

    </form>
</section>
<?php


if (isset($_GET['submit'])) {
    $idGite = $_GET['id_gite'];
    $firstname_client = $_GET['firstname_client'];
    $lastname_client = $_GET['lastname_client'];
    $phone_client = $_GET['phone_client'];
    $mail_client = $_GET['mail_client'];
    $nbr_traveller = $_GET['nbr_traveller'];
    
    // Date Réservation
    $start_date_reserv = $_GET['start_date_reserv'];
    $end_date_reserv = $_GET['end_date_reserv'];
    var_dump($start_date_reserv);
    var_dump($end_date_reserv);



    // $start_nbr_nuit = new DateTime($_GET['start_date_reserv']);
    // $start_nbr_nuit = DateTime::createFromFormat('D-M-Y', $_GET['start_date_reserv']);
    // // echo $start_nbr_nuit->format('Y-m-d');


    // $end_nbr_nuit = new DateTime($_GET['end_date_reserv']);
    // $end_nbr_nuit = DateTime::createFromFormat('D-M-Y', $_GET['end_date_reserv']);
    // $end_nbr_nuit->modify(' +1 day');
    // // echo $end_nbr_nuit->format('D-M-Y');

    // $interval = DateInterval::createFromDateString('1 day');
    // $period = new DatePeriod($start_nbr_nuit, $interval, $end_nbr_nuit);
    // var_dump($period);




    // Création de la connection à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=cottage;charset=utf8', 'root', '');
    } catch (PDOException $e) {
        echo 'Echec de la connexion : ' . $e->getMessage();
    }

    echo 'COUCOU !!!!';


    $req = $db->prepare('INSERT INTO `customer` (`firstname_client`, `lastname_client`, `phone_client`, `mail_client`, `nbr_traveller`) VALUES (:firstname_client, :lastname_client, :phone_client, :mail_client, :nbr_traveller)');

    $req->bindParam('firstname_client', $firstname_client, PDO::PARAM_STR);
    $req->bindParam('lastname_client', $lastname_client, PDO::PARAM_STR);
    $req->bindParam('phone_client', $phone_client, PDO::PARAM_STR);
    $req->bindParam('mail_client', $mail_client, PDO::PARAM_STR);
    $req->bindParam('nbr_traveller', $nbr_traveller, PDO::PARAM_INT);
    $req->execute();
    
    // if(!empty($_GET['start_date_reserv'] && $_GET['end_date_reserv'])){
        // foreach ($period as $night){
            // echo $night->format('Y-m-d');
        
            // $req = $db->prepare('SELECT `id_gite`, `price_night` FROM `cottages`');
            // $req->bindParam('id_gite', $idGite, PDO::PARAM_STR);
            // $req->execute();


            // $req = $db->prepare('SELECT `id_client` FROM `customer`');
            // $req->bindParam('id_client', $idClient, PDO::PARAM_STR);

            $req = $db->prepare('INSERT INTO bookings (`id_gite`, `id_client`, `start_date_reserv`, `end_date_reserv`,`nbr_nuit`, `price_reserv`) VALUES (:id_gite, :id_client, 5, 15) RETURNING `id_client`');
             echo 'Sa marche';

            $req->bindParam('id_gite', $idGite, PDO::PARAM_STR);
            $req->bindParam('id_client', $idClient, PDO::PARAM_STR);
            $req->bindParam('start_date_reserv', $start_date_reserv, PDO::PARAM_STR);
            $req->bindParam('end_date_reserv', $end_date_reserv, PDO::PARAM_STR);
            $req->bindParam('nbr_nuit', $nbr_nuit, PDO::PARAM_INT);
            $req->bindParam('price_reserv', $price_reserv, PDO::PARAM_INT);
           
            var_dump($idClient);
            $idClient = $db->lastInsertId();
            
        // }
        
    // }
    
}
require_once './templates/footer.php';
?>