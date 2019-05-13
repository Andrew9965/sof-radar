<?php

namespace App\Models\Traits;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Collection;

trait ChartSorterTrait {

    /**
     * The name of the variable with a start date.
     *
     * @var string
     */
    protected $start_date_field = 'start';

    /**
     * The name of the variable with the end date.
     *
     * @var string
     */
    protected $end_date_field = 'end';

    /**
     * Autoswitch headers for days if a period of one month is selected.
     *
     * @var bool
     */
    protected $autoswitch_headers = true;

    /**
     * The name of the sort field.
     *
     * @var string
     */
    protected $between_field = 'created_at';

    /**
     * Order ASC field. Or false if you need to disable this option.
     *
     * @var string|bool
     */
    protected $orderByASC = 'created_at';

    /**
     * Order DESC field. Or false if you need to disable this option.
     *
     * @var string|bool
     */
    protected $orderByDESC = false;

    /**
     * Data format for group working data
     *
     * @var string
     */
    protected $groupFormat = 'd.m.Y';

    /**
     * Data day format for group working data
     *
     * @var string
     */
    protected $groupDayFormat = 'd.m.Y';

    /**
     * Field for grouping
     *
     * @var string
     */
    protected $groupField = 'created_at';

    /**
     * Working data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Carbon date start Object
     *
     * @var Object
     */
    protected $start = false;

    /**
     * Carbon date end Object
     *
     * @var Object
     */
    protected $end = false;

    /**
     * First item Object
     *
     * @var Object
     */
    protected $first = false;

    /**
     * Last item Object
     *
     * @var Object
     */
    protected $last = false;

    /**
     * Add fields with the highest possible date range to the conversion.
     *
     * @var bool
     */
    protected $convertWithDates = false;

    /**
     * The name of the field as a result of the conversion with the first record of the date.
     *
     * @var string
     */
    protected $responseFirstDateField = 'startDate';

    /**
     * The name of the field as a result of the conversion with the last date entry.
     *
     * @var string
     */
    protected $responseLastDateField = 'endDate';

    /**
     * Selected data title
     *
     * @var string
     */
    protected $title = '';

    /**
     * Chart type selected data
     *
     * @var string
     */
    protected $chartType = 'bar';

    protected $modelFilter = true;

    /**
     * Chart scope for model
     *
     * @param $query
     * @return mixed
     */
    public function scopeChart($query)
    {
        $request = request();
        if($this->convertWithDates){
            $all = $this->call('filter', $query, false)->orderBy($this->groupField, 'asc')->get(['created_at']);
            if($all->count()){
                $this->first = $all->first()->created_at;
                $this->last = $all->last()->created_at;
            }
        }
        $this->start = Carbon::parse($request->{$this->start_date_field} && count(explode('-', $request->{$this->start_date_field})) == 3 ? $request->{$this->start_date_field} : date('Y-m-d'))->startOfDay();
        $this->end = Carbon::parse($request->{$this->end_date_field} && count(explode('-', $request->{$this->end_date_field})) == 3 ? $request->{$this->end_date_field} : date('Y-m-d'))->endOfDay();
        $query = $this->call('filter', $query, false);
        $query = $query->whereBetween($this->between_field, [$this->start, $this->end]);
        if($this->orderByASC && is_string($this->orderByASC)) $query = $query->orderBy($this->orderByASC, 'asc');
        if($this->orderByDESC && is_string($this->orderByDESC)) $query = $query->orderBy($this->orderByDESC, 'desc');
        $this->data = $query->get();

        return $this;
    }

    /**
     * Convert data for Cart Array
     *
     * @return array
     * @throws \Exception
     */
    public function convert()
    {
        if(!$this->start || !$this->end) throw new \Exception("Necessary to initialize the scope Cart");

        if($this->get()->count()){
            $response = [
                'status' => 'success',
                'message' => '',
                'data' => [['name' => $this->title, 'chartType' => $this->chartType, 'values' => $this->get()->values()->toArray()]],
                'labels' => $this->get()->keys()->map(function($item) {
                    return $this->formatResponseLabel($item);
                })->toArray()
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'no statistic',
                'data' => [],
                'labels' => []
            ];
        }

        if($this->convertWithDates && $this->first && $this->last){
            $response[$this->responseFirstDateField] = $this->formatResponseDates($this->first);
            $response[$this->responseLastDateField] = $this->formatResponseDates($this->last);
        }

        return $response;
    }

    /**
     * Formatter Values for working data
     *
     * @param $value
     * @return mixed
     */
    public function formatResponseValue($value)
    {
        return $value;
    }

    /**
     * Formatter Labels for convert response
     *
     * @param $label
     * @return mixed
     */
    public function formatResponseLabel($label)
    {
        return $label;
    }

    /**
     * Formatter First/Last dates for convert response
     *
     * @param $created_at
     * @return array
     * @internal param $object
     */
    public function formatResponseDates($created_at)
    {
        return [
            'year' => $created_at->format('Y'),
            'month' => $created_at->format('m'),
            'day' => $created_at->format('d')
        ];
    }

    /**
     * Group working data
     *
     * @return $this
     * @throws \Exception
     * @internal param bool $group
     */
    public function group()
    {
        if(strrpos($this->groupField, '_at') === false)
            throw new \Exception('You must specify a time zone field.');

        $format = $this->groupFormat;

        if($this->autoswitch_headers && $this->start->format('m.Y') === $this->end->format('m.Y'))
            $format = $this->groupDayFormat;

        $this->data = $this->data->groupBy(function ($data) use ($format) {
            return Carbon::parse($data->{$this->groupField})->format($format);
        });

        return $this;
    }

    /**
     * Modify collect working data
     *
     * @param Closure $callback
     * @return $this
     */
    public function collect(Closure $callback)
    {
        $this->data = $callback(collect($this->data));

        return $this;
    }

    /**
     * Config setter
     *
     * @param $option
     * @param bool $value
     * @return $this
     * @throws \Exception
     */
    public function set($option, $value=false)
    {
        if(is_array($option)) {
            foreach ($option as $key => $val) { $this->set($key, $val); }
            return $this;
        }

        if(!isset($this->{$option}))
            $option = camel_case($option);
        if(!isset($this->{$option}))
            $option = snake_case($option);
        if(!isset($this->{$option}))
            throw new \Exception($option.': Not Found!');

        $this->{$option} = $value;

        return $this;
    }

    /**
     * Caller for Model Methods
     *
     * @param $method
     * @param $parameters
     * @param bool $throw
     * @return mixed
     * @throws \Exception
     */
    public function call($method, $parameters, $throw=true)
    {
        $method = camel_case("chart_{$method}");

        if(!$this->modelFilter && $method == 'chartFilter') return $parameters;

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method], $parameters);
        }

        if($throw) throw new \Exception("Method [$method] does not exist.");
        else return $parameters;
    }

    /**
     * Data Getter
     *
     * @return Collection
     */
    public function get()
    {
        return collect($this->data)->map(function ($item) {
            return $this->formatResponseValue($item);
        });
    }
}