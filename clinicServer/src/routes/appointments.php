<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// View All Appointments
$app->get('/api/appointments', function(Request $request, Response $response){
     $sql = "SELECT * FROM appointments";

     try{
        //Get the database object
        $db = new db();
        // call connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $all_appointments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($all_appointments);

     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

     }

});

//View an Appointment

$app->get('/api/appointment/{id}', function(Request $request, Response $response){
     $id = $request->getAttribute('id');

     $sql = "SELECT * FROM appointments WHERE id = $id";

     try{
        //Get the database object
        $db = new db();
        // call connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $single_appointment = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($single_appointment);

     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

     }

});

//Create New Appointment

$app->post('/api/appointment/new', function(Request $request, Response $response){
     $first_name = $request->getParam('first_name');
     $last_name = $request->getParam('last_name');
     $date_of_birth = $request->getParam('date_of_birth');
     $phone_number = $request->getParam('phone_number');
     $email_address = $request->getParam('email_address');
     $mailing_address = $request->getParam('mailing_address');
     $city = $request->getParam('city');
     $province = $request->getParam('province');
     $postal_code = $request->getParam('postal_code');
     $doctor_name = $request->getParam('doctor_name');
     $reason = $request->getParam('reason');
     $appointment_date = $request->getParam('appointment_date');

     $sql = "INSERT INTO appointments (first_name, last_name, date_of_birth, phone_number, email_address, mailing_address, city, province, postal_code, doctor_name, reason, appointment_date) VALUES (:first_name, :last_name, :date_of_birth, :phone_number, :email_address, :mailing_address, :city, :province, :postal_code, :doctor_name, :reason, :appointment_date)";

     try{
        //Get the database object
        $db = new db();
        // call connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':mailing_address', $mailing_address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':doctor_name', $doctor_name);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':appointment_date', $appointment_date);

        $stmt->execute();

        echo '{"notice":{"text": "New Appointment is created"}}';


     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

     }

});

//Update an appointment

$app->put('/api/appointment/update/{id}', function(Request $request, Response $response){
     $id = $request->getAttribute('id');
     $first_name = $request->getParam('first_name');
     $last_name = $request->getParam('last_name');
     $date_of_birth = $request->getParam('date_of_birth');
     $phone_number = $request->getParam('phone_number');
     $email_address = $request->getParam('email_address');
     $mailing_address = $request->getParam('mailing_address');
     $city = $request->getParam('city');
     $province = $request->getParam('province');
     $postal_code = $request->getParam('postal_code');
     $doctor_name = $request->getParam('doctor_name');
     $reason = $request->getParam('reason');
     $appointment_date = $request->getParam('appointment_date');


     $sql = "UPDATE appointments SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth, phone_number = :phone_number, email_address = :email_address, mailing_address = :mailing_address, city = :city, province = :province, postal_code = :postal_code, doctor_name = :doctor_name, reason = :reason, appointment_date = :appointment_date WHERE id = $id";

     try{
        //Get the database object
        $db = new db();
        // call connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':mailing_address', $mailing_address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':doctor_name', $doctor_name);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':appointment_date', $appointment_date);

        $stmt->execute();

        echo '{"notice":{"text": "An existing appointment is updated"}}';


     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

     }

});

//Delete an Appointment

$app->delete('/api/appointment/delete/{id}', function(Request $request, Response $response){
     $id = $request->getAttribute('id');

     $sql = "DELETE FROM appointments WHERE id = $id";

     try{
        //Get the database object
        $db = new db();
        // call connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice":{"text": "An Appointment is deleted"}}';

     } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';

     }

});

