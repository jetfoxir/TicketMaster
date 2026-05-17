<?php
namespace App\Core;

class Validator
{
    protected $errors = [];

    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            $value = $data[$field] ?? '';
            foreach ($rulesArray as $rule) {
                $params = [];
                if (strpos($rule, ':') !== false) {
                    [$rule, $param] = explode(':', $rule, 2);
                    $params = explode(',', $param);
                }
                switch ($rule) {
                    case 'required':
                        if (empty(trim($value))) {
                            $this->errors[$field][] = "فیلد {$field} الزامی است.";
                        }
                        break;
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$field][] = "ایمیل معتبر نیست.";
                        }
                        break;
                    case 'min':
                        $min = $params[0] ?? 0;
                        if (mb_strlen($value) < $min) {
                            $this->errors[$field][] = "حداقل {$min} کاراکتر نیاز است.";
                        }
                        break;
                    case 'max':
                        $max = $params[0] ?? 0;
                        if (mb_strlen($value) > $max) {
                            $this->errors[$field][] = "حداکثر {$max} کاراکتر مجاز است.";
                        }
                        break;
                    case 'same':
                        $other = $params[0] ?? '';
                        if ($value !== ($data[$other] ?? '')) {
                            $this->errors[$field][] = "تطابق ندارد.";
                        }
                        break;
                    case 'unique':
                        $table = $params[0] ?? '';
                        $column = $params[1] ?? $field;
                        $ignoreId = $params[2] ?? null;
                        $db = Database::getInstance()->getConnection();
                        $sql = "SELECT COUNT(*) FROM `{$table}` WHERE `{$column}` = :value";
                        $bind = [':value' => $value];
                        if ($ignoreId) {
                            $sql .= " AND id != :id";
                            $bind[':id'] = $ignoreId;
                        }
                        $stmt = $db->prepare($sql);
                        $stmt->execute($bind);
                        if ($stmt->fetchColumn() > 0) {
                            $this->errors[$field][] = "این {$field} قبلاً استفاده شده است.";
                        }
                        break;
                }
            }
        }
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}