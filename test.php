<?php

$hash = '$2y$10$PGCNBj0EurrgGkoesGSlCuJnhvq99T3SZoTgmAV3gAUcCyAIekw9y';

if (password_verify('Segura1!', $hash)) {
    echo "La contraseña es correcta";
} else {
    echo "La contraseña NO coincide";
}
