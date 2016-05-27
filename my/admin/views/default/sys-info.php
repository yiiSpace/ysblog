<div class="admin-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>

    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>

    </p>

    <h3> 系统信息</h3>
    <?php
    // 直接拷贝https://github.com/abhi1693/yii2-system-info 页面的方法列表 ！！！（我很懒的哦！）
    $infoStrings = '
    getOS
    getKernelVersion
    getHostname
    getCpuModel
    getCpuVendor
    getCpuFreq
    getCpuArchitecture
    getCpuCores
    getLoad
    getUpTime
    getPhpVersion
    getServerName
    getServerProtocol
    getServerSoftware
    getTotalMemory
';

    $infoItems = preg_split('|\s+|', $infoStrings);
    $infoItems = array_filter($infoItems, function ($item) {
        return empty($item) ? false : true;

    });
    // print_r($infoItems) ;
    use abhimanyu\systemInfo\SystemInfo;

    // Get the class to work with the current operating system
    $system = SystemInfo::getInfo();

    $modelData = [];
    $modelData = array_reduce($infoItems, function ($result, $current) use ($system) {
        if (method_exists($system, $current)) {
            $result[$current] = call_user_func([$system, $current]);
        }
        return $result;
    }, []);

    // print_r($modelData) ; die();
    // Captain Obvious was here
    // $system::getHostname();
    $model = new \yii\base\DynamicModel($modelData);

    ?>

    <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => $infoItems,
    ]) ?>
</div>
