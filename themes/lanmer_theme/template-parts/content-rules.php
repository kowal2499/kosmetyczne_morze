<?php

$rules = get_option(\admin\Settings::RULES);

if (empty($rules)) {
    return;
}

?>

<div class="rules">
    <table class="table">

    <?php foreach ($rules as $num => $rule): ?>
    <tr>
        <td class="section-title"><?php echo $rule['title']; ?></td>

        <td class="section-body">
            <div class="body-inner">
                <div class="text-center"><strong>&sect; <?php echo $num+1; ?></strong></div><br>
                <?php echo str_replace(PHP_EOL, '<br>', $rule['paragraph']); ?>
            </div>
        </td>

    </tr>

    <?php endforeach; ?>

    </table>

</div>