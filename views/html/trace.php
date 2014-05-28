<div class="mammoth-debug-wrapper">
    <table class="mammoth-debug-table mammoth-debug-table-bordered mammoth-debug-table-striped">
        <thead>
            <th>Line</th>
            <th>File</th>
            <th>Method</th>
            <th>Arguments</th>
        </thead>
        <tbody>
            <?php foreach ($stacktrace as $trace): ?>
                <?php
                    $internal = '';
                    if (isset($trace['file'])) {
                        $internal .= $trace['file'];
                    } elseif (isset($trace['class'])) {
                        $internal .= $trace['class'];
                    }
                ?>
                <tr class="<?php if (preg_match('/mammoth.error/i', $internal) !== 0) echo 'mammoth-debug-internal'; ?>">
                    <td><b><?= isset($trace['line']) ? $trace['line'] : '&nbsp;'; ?></b></td>
                    <td>
                        <?php
                            if (isset($trace['file'])) {
                                $reverse = Mammoth\Debug\Dump::reverseFile($trace['file']);
                                $file = $trace['file'];
                                echo "<span class='mammoth-debug-path' title='$file'>$reverse</span>";
                            } else {
                                echo '&nbsp;';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $method = isset($trace['class']) ? $trace['class'] : '';
                            $method .= isset($trace['type']) ? $trace['type'] : '';
                            $method .= isset($trace['function']) ? $trace['function'] : '';
                            echo $method ?: '&nbsp;';
                        ?>
                    </td>
                    <td>
                        <?php
                            if (isset($trace['args'])) {
                                echo Mammoth\Debug\Dump::implodeArguments($trace['args']);
                            } else {
                                echo '&nbsp;';
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
