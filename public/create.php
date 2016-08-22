<?php

//header('Content-type: application/json');
$cnn = mysqli_connect('localhost', 'root', '', 'pigments') or die("Connection Error");

if(isset($_POST['sample']))
{
        $json = str_replace('\"', '"', $_POST['sample']);
    	$j = json_decode($json, true);
    	$id_station = $j['id_station'];
    	$date = mb_strimwidth($j['date'], 0, 10);
    	$comment = $j['comment'];
    	$serial_number = $j['serial_number'];
        
        $query = mysqli_query($cnn, "INSERT INTO samples (id_station, date, comment, serial_number) VALUES ('$id_station', '$date', '$comment', '$serial_number')");
        http_response_code(200);
        echo 'Good';
        
        $pigment = $j['pigment'];
        $id_trophic_characterization = $j['id_trophic_characterization'];
        $id_sample = mysqli_insert_id($cnn);
        $id_horizon = $j['id_horizon'];
        $volume_of_filtered_water = $j['volume_of_filtered_water'];
        $chlorophyll_a_concentration = $j['chlorophyll_a_concentration'];
        $chlorophyll_b_concentration = $j['chlorophyll_b_concentration'];
        $chlorophyll_c_concentration = $j['chlorophyll_c_concentration'];
        $a = $j['a'];
        $pigment_index = $j['pigment_index'];
        $pheopigments = $j['pheopigments'];
        $ratio_of_cl_a_to_cl_c = $j['ratio_of_cl_a_to_cl_c'];
        $pigment_comment = $j['pigment_comment'];
        $pigment_serial_number = $j['pigment_serial_number'];
        
        if($pigment)
        {
/**
 *             echo "id_trophic_characterization " . $id_trophic_characterization . "\n";
 *             echo "id_sample " . $id_sample . "\n";
 *             echo "id_horizon " . $id_horizon . "\n";
 *             echo "volume_of_filtered_water " . $volume_of_filtered_water . "\n";
 *             echo "id_trophic_characterization " . $id_trophic_characterization . "\n";
 *             echo "chlorophyll_a_concentration " . $chlorophyll_a_concentration . "\n";
 *             echo "chlorophyll_b_concentration " . $chlorophyll_b_concentration . "\n";
 *             echo "chlorophyll_c_concentration " . $chlorophyll_c_concentration . "\n";
 *             echo "a " . $a . "\n";
 *             echo "pigment_index " . $pigment_index . "\n";
 *             echo "pheopigments " . $pheopigments . "\n";
 *             echo "ratio_of_cl_a_to_cl_c " . $ratio_of_cl_a_to_cl_c . "\n";
 *             echo "pigment_comment " . $pigment_comment . "\n";
 *             echo "pigment_serial_number " . $pigment_serial_number . "\n";
 */
            
            $query = mysqli_query($cnn, "INSERT INTO photosynthetic_pigments_samples (id_trophic_characterization, id_sample, id_horizon, volume_of_filtered_water, chlorophyll_a_concentration, chlorophyll_b_concentration, chlorophyll_c_concentration, A, pigment_index, pheopigments, ratio_of_cl_a_to_cl_c, pigment_comment, pigment_serial_number)" .
            "VALUES ('$id_trophic_characterization', '$id_sample', '$id_horizon', '$volume_of_filtered_water', '$chlorophyll_a_concentration', '$chlorophyll_b_concentration', '$chlorophyll_c_concentration', '$A', '$pigment_index', '$pheopigments', '$ratio_of_cl_a_to_cl_c', '$pigment_comment', '$pigment_serial_number')");
        }
}  
else
{
    http_response_header(400);
}


?>