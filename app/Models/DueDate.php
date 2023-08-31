<?php

    namespace App\Models;

    use DateTime;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
 * App\Models\DueDate
 *
 * @property int $id
 * @property string $due_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|DueDate newModelQuery()
 * @method static Builder|DueDate newQuery()
 * @method static Builder|DueDate query()
 * @method static Builder|DueDate whereCreatedAt($value)
 * @method static Builder|DueDate whereDueDate($value)
 * @method static Builder|DueDate whereId($value)
 * @method static Builder|DueDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
    class DueDate extends Model
    {
        use HasFactory;

        protected $table = 'due_dates';

        const DEFAULT_AMOUNT_OF_WEEKS = 8;

        protected $fillable = [
            'due_date'
        ];

        public static function defaultAmountOfWeeks()
        {
            return self::DEFAULT_AMOUNT_OF_WEEKS;
        }

        /**
         * @throws \Exception
         */
        public static function defaultDueDate()
        {
            $date = new DateTime();
            // add the default amount of weeks to the current date
            $date->add(new \DateInterval('P' . self::defaultAmountOfWeeks() . 'W'));
            return new DueDate(['due_date' => $date->format('Y-m-d H:i:s')]);
        }

        public static function activeDueDate()
        {
            return DueDate::futureDueDates()->first();
        }

        public static function futureDueDates()
        {
            return DueDate::where('due_date', '>', date('Y-m-d H:i:s'))->orderBy('due_date')->get();
        }

        public static function pastDueDates()
        {
            return DueDate::where('due_date', '<', date('Y-m-d H:i:s'))->orderBy('due_date', 'desc')->get();
        }
    }
