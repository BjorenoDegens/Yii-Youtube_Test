<?php
echo \yii\bootstrap5\Nav::widget([
        "options" => [
                'class' => 'd-flex flex-column nav-pills'
        ],
        'items' => [
                [
                    'label' => 'Dashboard', 'url' => ['/video/index']
                ],
                [
                    'label' => 'Upload', 'url' => ['/video/create']

                ]
        ]
        ]);
?>
