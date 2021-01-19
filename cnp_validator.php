<?php


function anBisect($an) {
    if(($an % 4 == 0) && ($an % 100 != 0))
        return true;
    if($an % 400 == 0)
        return true;
    return false;
}
function getAn($cnpArray) {
    //verificare an
    $an = ((int)$cnpArray[1] * 10) + (int)$cnpArray[2];
    switch ($cnpArray[0]) {
        case 1  : 
        case 2 :
            $an += 1900;
            break; 
        case 3  :
        case 4 :
            $an += 1800;
            break; 
        case 5  :
        case 6 :
            $an += 2000;
            break; 
        case 7 :
        case 8 :
        case 9 :                
            $an += 1901;
            break;
        default : 
            return 0;
    }
    return $an;
}
function validareAn($an) {
    return ($an > 1800 && $an < 2099);
}
function getLuna($cnpArray) {
    $luna = ((int)$cnpArray[3] * 10) + (int)$cnpArray[4];
    return $luna;
}
function validareLuna($luna) {
    return ($luna >= 1 && $luna <= 12);
}
function validareZi($cnpArray) {
    $zi = ((int)$cnpArray[5] * 10) + (int)$cnpArray[6];
    $an = getAn($cnpArray);
    $luna = getLuna($cnpArray);
    if($luna == 2) {
        if(anBisect($an)) {
           return ($zi >= 1 && $zi <= 29); 
        } else {
            return ($zi >= 1 && $zi <= 28);
        }   
    }
    return ($zi >= 1 && $zi <= 31);
}

function validareJudet($cnpArray) {
    $judet = ((int)$cnpArray[7] * 10) + (int)$cnpArray[8];
    return ($judet >= 1 && $judet <= 52);
}

function validateCnp($input) {
    
    $hash = array( 2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9 );
    $hashValue = 0;
    //verificare lungime
    if (strlen($input) != 13) {
        echo "Lungimea trebuie sa fie de 13 caractere"; 
        return false;
    }
    $cnpArray = str_split($input);
    foreach($cnpArray as $key => $value) {
        if(!is_numeric($value)) {
            echo "CNP-ul trebuie sa contina doar cifre"; 
            return false;
        }
        if($key == 12) { //sarim peste ultima cifra (fiind fix cifra de control)
            continue;
        }
        $hashValue += ($value * $hash[$key]);
    }
    $hashValue = $hashValue % 11;
    if($hashValue == 10) {
        $hashValue = 1;
    }
    if(!validareAn(getAn($cnpArray))) {
        echo "Anul nu este valid.";
        return false;
    }
    if(!validareLuna(getLuna($cnpArray))){
        echo "Luna nu este valida";
        return false;
    } 
    if(!validareZi($cnpArray)){
        echo "Ziua nu este valida";
        return false;
    } 
    if(!validareJudet($cnpArray)){
        echo "Judetul nu este valid";
        return false;
    }
    if($hashValue != $cnpArray[12]){
        echo "Cifra de control este incorecta";
        return false;
    }
    return true;
}

if(validateCnp("1931103298751")){
    echo "<br>CNP-ul este valid";
} else {
    echo "<br>CNP-ul este invalid";
}
