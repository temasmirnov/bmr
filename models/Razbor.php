<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "razbor".
 *
 * @property integer $razbor_id
 * @property string $title
 * @property string $creation_date
 * @property string $razbor_date
 * @property string $code
 * @property string $short_description
 * @property integer $sort
 * @property string $tags
 * @property integer $razbor_num
 * @property string $youtube_url
 * @property string $activities_str
 * @property string $trainers_str
 *
 * @property Favorite[] $favorites
 * @property Note[] $notes
 * @property RazborHasActivity[] $razborHasActivities
 * @property Activity[] $activities
 * @property RazborHasTrainer[] $razborHasTrainers
 * @property Trainer[] $trainers
 * @property Timecode[] $timecodes
 */
class Razbor extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'razbor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'razbor_num'], 'required'],
            [['sort', 'razbor_num'], 'integer'],
            [['title', 'short_description'], 'string', 'max' => 1000],
            [['creation_date', 'razbor_date', 'code'], 'string', 'max' => 45],
            [['tags', 'activities_str', 'trainers_str'], 'string', 'max' => 5000],
            [['youtube_url'], 'url'],
        ];
    }

    public function behaviors() {
        return [
            // Other behaviors
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_date',
                'updatedAtAttribute' => false,
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'razbor_id' => 'ID',
            'title' => 'Название',
            'creation_date' => 'Creation Date',
            'razbor_date' => 'Дата разбора',
            'code' => 'URL-код',
            'short_description' => 'Описание',
            'sort' => 'Сортировка',
            'tags' => 'Теги',
            'razbor_num' => 'Количество разборов',
            'youtube_url' => 'Youtube-ссылка',
            'activities_str' => 'Ниши',
            'trainers_str' => 'Тренеры',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites() {
        return $this->hasMany(Favorite::className(), ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes() {
        return $this->hasMany(Note::className(), ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazborHasActivities() {
        return $this->hasMany(RazborHasActivity::className(), ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities() {
        return $this->hasMany(Activity::className(), ['activity_id' => 'activity_id'])->viaTable('razbor_has_activity', ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazborHasTrainers() {
        return $this->hasMany(RazborHasTrainer::className(), ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainers() {
        return $this->hasMany(Trainer::className(), ['trainer_id' => 'trainer_id'])->viaTable('razbor_has_trainer', ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimecodes() {
        return $this->hasMany(Timecode::className(), ['razbor_id' => 'razbor_id']);
    }

}
