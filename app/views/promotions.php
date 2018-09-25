<?php
/**
 * @var string $modifiedPromotion
 * @var array $promotions
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Promotions</title>
</head>
<body>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="background-color: #ffffcc"><?= $_SESSION['error'] ?></p>
    <?php endif; ?>
    <p><b>Modified promotion:</b> <?= $modifiedPromotion ?></p>
    <ul>
        <?php foreach ($promotions as $promotion): ?>
                <li><?= $promotion->generateUrl() ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>