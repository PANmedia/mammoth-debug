<?php
    $debug = array();
    if (isset($_POST)) $debug['post'] = $_POST;
    if (isset($_GET)) $debug['get'] = $_GET;
    if (isset($_REQUEST)) $debug['request'] = $_REQUEST;
    if (isset($_COOKIE)) $debug['cookie'] = $_COOKIE;
    if (isset($_SESSION)) $debug['session'] = $_SESSION;
    if (isset($_SERVER)) $debug['server'] = $_SERVER;
    if (isset($_ENV)) $debug['environment'] = $_ENV;
    if (isset($_FILES)) $debug['files'] = $_FILES;

//    $constants = get_defined_constants(true);
//    if (isset($constants['user'])) $debug['constants'] = $constants['user'];

?>
<h2>Debug Data</h2>
<?php foreach ($debug as $type => $data): ?>
    <?php if (empty($data)) continue; ?>
    <div class="mammoth-debug-wrapper">
        <table class="mammoth-debug-table mammoth-debug-table-bordered mammoth-debug-table-striped">
            <thead>
                <tr>
                    <th colspan="2"><?= strtoupper($type); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $name => $value): ?>
                    <?php if (stripos($name, 'pass') !== false) continue; // Attempt to filter passwords ?>
                    <tr>
                        <td><?= $name ? htmlentities($name) : '&nbsp;'; ?></td>
                        <?php if (is_array($value) || is_object($value)): ?>
                            <td><?php var_dump($value); ?></td>
                        <?php else: ?>
                            <td><?= $value ? htmlentities($value) : '&nbsp;'; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>