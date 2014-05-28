<?php
    if (empty($records)) {
        return;
    }

    $colors = array(
        '000', '666', '999',
        '600', '060', '006',
        '660', '606', '066',
        '960', '096', '906',
        '690', '069', '609',
        '360', '036', '306',
        '630', '063', '603',
        '930', '036', '306',
        '630', '063', '603',
        '963', '396', '936',
        '693', '369', '639',
    );
?>
<h2>Log</h2>

<div class="mammoth-debug-wrapper">
    <table class="mammoth-debug-table mammoth-debug-table-bordered mammoth-debug-table-striped">
        <thead>
            <th>Owner</th>
            <th>Message</th>
        </thead>
        <tbody>
            <?php foreach ($records as $record): ?>
                <?php
                    $message = $record['message'];
                    $owner = null;
                    if (preg_match('@^\(([a-zA-Z0-9_\\\]+)\): (.*)@', $record['message'], $match)) {
                        $owner = $match[1];
                        $message = $match[2];
                    }
                    $hex = crc32($owner);
                ?>
                <tr>
                    <td style="color:#<?= $colors[abs($hex % count($colors))] ?>"><b><?= $owner ? htmlentities($owner) : '&nbsp;'; ?></b></td>
                    <td><?= $message ? htmlentities($message) : '&nbsp;'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
