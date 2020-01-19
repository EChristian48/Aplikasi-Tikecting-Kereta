<?php

require 'connections.php';

function Alert($msg)
{
    $script = "<script>alert('$msg')</script>";
    echo $script;
    return $script;
}

function Redirect($link)
{
    $script = "<script>document.location.href='$link'</script>";
    echo $script;
    return $script;
}

function SelectQuery($tableName, $fieldName = '*')
{
    global $con;
    $Query = "SELECT $fieldName FROM $tableName";
    return mysqli_query($con, $Query);
}

function SelectWhereQuery($tableName, $condition, $fieldName = '*')
{
    global $con;
    $query = "SELECT $fieldName FROM $tableName WHERE $condition";
    return mysqli_query($con, $query);
}

function InsertQuery($tableName, $values, $fields)
{

    global $con;

    $fieldNameString = "";
    $valueString = "";

    if ($fields == 'all')
    {
        $queryResult = GetFieldName($tableName);
    
        $i = 0;
        while ($fieldNameRec = mysqli_fetch_array($queryResult))
        {
        
            $fieldNameArray[$i++] = $fieldNameRec[0];
        }
        
        foreach ($fieldNameArray as $index => $field)
        {

            if ($index == 0)
            {
                $fieldNameString = $field;
            }
            else
            {
                $fieldNameString = $fieldNameString . ", " . $field;
            }
        }
    }
    else
    {
        foreach ($fields as $index => $field)
        {

            if ($index == 0)
            {
                $fieldNameString = $field;
            }
            else
            {
                $fieldNameString = $fieldNameString . ", " . $field;
            }
        }
    }

    foreach ($values as $index => $value)
    {
        $valueWithThatThing = "'" . $value . "'";

        if ($index == 0)
        {
            $valueString = $valueWithThatThing;
        }
        else
        {
            $valueString = $valueString . ", " . $valueWithThatThing;
        }
    }

    $query = "INSERT INTO $tableName ($fieldNameString) VALUES ($valueString)";
    return mysqli_query($con, $query);
}

function UpdateQuery ($tableName, $fieldAndValue, $idFieldAndValue)
{
    global $con;
    $query = "UPDATE $tableName SET $fieldAndValue WHERE $idFieldAndValue";
    return mysqli_query($con, $query);
}

function DeleteQuery($tableName, $condition)
{
    global $con;
    $query = "DELETE FROM $tableName WHERE $condition";
    return mysqli_query($con, $query);
}

function GetFieldName($tableName)
{
    global $infoCon;
    $query = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_NAME = '$tableName'";   
    return mysqli_query($infoCon, $query);
}

function TruncateQuery ($tableName)
{
    global $con;
    $query = "TRUNCATE $tableName";
    return mysqli_query($con, $query);
}

?>