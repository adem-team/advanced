<?php
use dpodium\filemanager\models\Tree;
use kartik\tree\Module;
// use dpodium\filemanager\models\tree;
use kartik\tree\TreeView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>



<?php
// print_r(Yii::getAlias('@treeview_part2').'files/tree_part2.php');
// die();

echo TreeView::widget([
     'query'=> Tree::find()->addOrderBy('root, lft'),  // single query fetch to render the tree
        
        'nodeAddlViews' => [ // view optional
            Module::VIEW_PART_2 => '@treeview_part2/files/tree_part2',
        ],
   
    // 'nodeView' => '@treeview_part2/files/tree_part2', view optional

    //  'nodeActions' => [  actions kartik tree view
    //     Module::NODE_MANAGE => Url::to(['/treemanager/node/manage']),
    //     Module::NODE_SAVE => Url::to(['/treemanager/node/save']),
    //     Module::NODE_REMOVE => Url::to(['/treemanager/node/remove']),
    //     Module::NODE_MOVE => Url::to(['/treemanager/node/move']),
    // ],

    // 'clientMessages'=>[   js button kartik treeview config
    // 'nodeTop'=>false,
    // ],
    'headingOptions' => ['label' => 'Categories'], // heading options
    // 'isAdmin'=> true,   // optional (toggle to enable admin mode)
    'headingOptions' => ['label' => 'Categories'],
    'rootOptions' => ['label' => '<i class="fa fa-tree"></i>'],
    'fontAwesome' => true, // font awesome 
    'displayValue' => 1,  // initial display value
    'iconEditSettings'=> [
        'show' => 'list', // list icon
        'listData' => [  // list icon view
            'folder' => 'Folder',
            'file' => 'File',
            'mobile' => 'Phone',
            'bell' => 'Bell',
        ]
    ],                     
    // 'softDelete'      => true,                        // normally not needed to change
    // 'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
]);
?>

 




