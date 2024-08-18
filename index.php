<?php
require_once('class/Messages.php');
require('class/GuesBook.php');
$book = null;
$elements = null;
$book = new GuesBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"], $_POST["message"])) {
    $message = new Messages($_POST["username"], $_POST["message"]);
    if ($message->is_valid()) {
        $book->addMessage($message);
        $_POST = [];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = $message->getError();
    }
}
if ($book instanceof GuesBook) {
    $elements = $book->getMessage();
}
$title = "livere d'or";
require('elements/header.php');
?>
<div class="container">
    <h2> livre d'ore </h2>
    <?php
    if (!empty($error)):
        ?>
        <div class="alert    alert-danger">
            Formulaire Invalide
        </div>
    <?php else: ?>
        <div class="alert  alert-success">
            Merci pour votre message
        </div>
    <?php endif ?>

    <form action="" method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="votre nom"
                class="form-control  <?= isset($error['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($error['username'])): ?>
                <div class="invalid-feedback">
                    <?= $error['username'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Votre message"
                class="form-control <?= isset($error['message']) ? 'is-invalid' : '' ?>"></textarea>
            <?php if (isset($error['message'])): ?>
                <div class="invalid-feedback">
                    <?= $error['message'] ?>
                </div>
            <?php endif ?>
        </div>
        <button type="submit" class="btn btn-primary">Envoye</button>
    </form>
    <?php if (!empty($elements)): ?>
        <div class="container">
            <h1>Vos Messages</h1>
            <?php foreach ($elements as $value): ?>
                <?= ($value->toHTML()) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>


<?php ?>


<?php
require('elements/footer.php');
?>