<?php
if ('POST' == strtoupper($_SERVER['REQUEST_METHOD'])) {
    $options = [
        'cost' => 11,
    ];

    echo $_POST['password'];
    $hashAndSalt = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

    echo "<div>
    <label></label>
    <input style=\"width:80%;\" type='disabled' value='$hashAndSalt'/>
    </div>";
} else {
}
?>

<form method="POST">
    <input type="text" name="password" />
    <button type="submit">Generate</button>
</form>