<?php

namespace backend\controllers;

use common\models\User;
use common\models\UserSearch;
use common\models\AuthItem;
use common\models\AuthAssignment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrivilege($id)
    {
    	//step1. 找出所有权限,提供给checkboxlist
    	$allPrivileges = AuthItem::find()->select(['name','description'])
    	->where(['type'=>1])->orderBy('description')->all();
    	 
    	foreach ($allPrivileges as $pri)
    	{
    		$allPrivilegesArray[$pri->name]=$pri->description;
    	}
    	//step2. 当前用户的权限
    	 
    	$AuthAssignments=AuthAssignment::find()->select(['item_name'])
    	->where(['user_id'=>$id])->orderBy('item_name')->all();
    	 
    	$AuthAssignmentsArray = array();
    	 
    	foreach ($AuthAssignments as $AuthAssignment)
    	{
    		array_push($AuthAssignmentsArray,$AuthAssignment->item_name);
    	}
    	 
    	//step3. 从表单提交的数据,来更新AuthAssignment表,从而用户的角色发生变化
    	if(isset($_POST['newPri']))
    	{
    		AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
    
    		$newPri = $_POST['newPri'];
    
    		$arrlength = count($newPri);
    
    		for($x=0;$x<$arrlength;$x++)
    		{
    		$aPri = new AuthAssignment();
    		$aPri->item_name = $newPri[$x];
    		$aPri->user_id = $id;
    		$aPri->created_at = time();
    		 
    		$aPri->save();
    		}
    		return $this->redirect(['index']);
    	}
    	 
    	//step4. 渲染checkBoxList表单
    
    			return $this->render('privilege',['id'=>$id,'AuthAssignmentArray'=>$AuthAssignmentsArray,
    			'allPrivilegesArray'=>$allPrivilegesArray]);
       			 
    }
}
