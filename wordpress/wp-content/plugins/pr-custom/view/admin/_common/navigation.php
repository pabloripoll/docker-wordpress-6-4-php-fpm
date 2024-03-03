<?php
$this->private();

$js = "javascript:;";
?>
<div class="row">
    <ul class="subsubsub">
        <?php
        $count = count($sections);
        foreach ($sections as $key => $value) :
            $pipe = $key == ($count - 1) ? '' : '|';
            ?>
            <li class="all">
                <a href="<?= $js; ?>" class="spapage" data-target="<?= $value['section']; ?>"><?= ucfirst($value['section']); ?> </a> <?= $pipe; ?>
            </li>
            <?php
        endforeach;
        ?>
    </ul>
    <div id="section-content" class="col-md-12"></div>
</div>