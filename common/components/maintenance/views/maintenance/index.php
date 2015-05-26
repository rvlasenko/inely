<div id="maintenance-content" style="margin-top: 10%">
    <p class="well">
        <?php echo Yii::t('common', $maintenanceText, [
            'retryAfter' => $retryAfter,
            'adminEmail' => Yii::$app->params['adminEmail']
        ]) ?>
    </p>
</div>