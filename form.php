<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="style.css">
 

    

</head>

<?php
    $fileName = "";
    $uploadDir = './uploads/';
    $uploadFile = "";
    
    if(!empty($_POST)) {

        if(array_key_exists("avatar" , $_POST)) {
            $fileName = $_POST['avatar'];
            if(file_exists($uploadDir.$fileName)) {
                unlink($uploadDir.$fileName);
            }
            
        }elseif(key($_POST) === 'send') {
            $fileName = $_FILES['avatar']['name'];
            $extension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $fileNewName = uniqid("image". true) . '.' . $extension;
            $uploadFile = $uploadDir.$fileNewName;
            $authorizedExtension = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $maxFileSize = 1000000;



            if(!in_array($extension, $authorizedExtension)) {
                $errors[] = 'Veuillez sélectionné une image de type jpg, jpeg, gif, png ou webp <br>';

            }
            if(($_FILES['avatar']['error'] === 1) || (filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)) {
                $errors[] = 'Votre fichier doit faire moins de 1M !';
            }

            if($_FILES['avatar']['error'] === 4) {
                $errors[] = 'Veuillez choisir un fichier à un envoyer !';
            }

            if (empty($errors)) {
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                    echo "Le fichier à bien été envoyé.";
            }
        }
    }

    if(!empty($errors)) {
        foreach($errors as $error) {
            echo $error;
        }
    }

?>
<body class="container">
    
    <form method="POST" enctype="multipart/form-data">

        <label for="imageUpload">Enregistrer votre Avatar : </label>
        <input type="file" name="avatar" id="imageUpload" accept="image/png, image/jpeg, image/gif, image/webp">
        <button name="send">Envoyer le fichier</button>
    </form>
    
    <article>
        <header>SpringField, IL</header>
        <div class="flex text">
            <div>Licence <br>#64209</div>
            <div>Birth date <br> 4-24-56</div>
            <div>Expires <br> 4-24-2015</div>
            <div>Class <br> None</div>
        </div>
        <div class="flex">
            <img src="<?php  if(isset($uploadFile)){ echo $uploadFile;} ?>">
            <div>
                <h2>Drivers License</h2>
                <p>HOMER SIMPSON</p>
                <p>69, OLD PLUMTREE BLVD</p>
                <p>SPRINGFIELD, IL 62701</p>
                <div class="flex desc">
                    <p>SEX<br> OK</p>
                    <p>HEIGHT<br> MEDIUM</p>
                    <p>WEIGHT <br>239</p>
                    <p>HAIR <br>NONE</p>
                    <p>EYES <br>OVAL</p>
                    
                </div>
                <p class="sign">x HOMER SIMPSON</p>
            </div>
            
        </div>
        
    </article>
    <?php 
        $files = array_diff(scandir("./uploads"), [".", ".."]);
        
    ?>
    <form method="POST">
        <select name="avatar" id="avatar">
            <?php foreach($files as $file): ?>
                <option value="<?= $file ?>"><?= $file ?></option>
            <?php endforeach ?>
        </select>
        <button name="delete">Supprimer la photo de profil ?</button>
    </form>
</body>
</html>