<?php
require_once __DIR__ . '/../models/DatabaseModel.php';

$db = new DatabaseModel();

try {
    $currencies = $db->select('currencies', 'code, name');
} catch (PDOException $e) {
    die("Adatbázis hiba: " . $e->getMessage());
}
?>

<!-- Base currency legördülő menü -->
<div style="margin-top: 20px;">
    <label for="base-currency">Válassz alap devizát:</label>
    <select id="base-currency" name="base-currency" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= htmlspecialchars($currency['code']) ?>"><?= htmlspecialchars($currency['code']) ?> - <?= htmlspecialchars($currency['name']) ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Target currency legördülő menü -->
<div style="margin-top: 20px;">
    <label for="target-currency">Válassz cél devizát:</label>
    <select id="target-currency" name="target-currency" required>
        <?php foreach ($currencies as $currency): ?>
            <option value="<?= htmlspecialchars($currency['code']) ?>"><?= htmlspecialchars($currency['code']) ?> - <?= htmlspecialchars($currency['name']) ?></option>
        <?php endforeach; ?>
    </select>
</div>
