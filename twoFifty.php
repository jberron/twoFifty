<?PHP

$missingNumber= $_GET['number'];

$maxNumber = 250;

if (!isset($missingNumber))
{
  $missingNumber = rand() % 250;
}
 
// ******** Prepare Strings ******

for ($i=0;$i<=$maxNumber;$i++)
{
  $expectedNumberArray[$i]=$i;
}

shuffle ($expectedNumberArray); // Shuffle the Array

foreach ($expectedNumberArray as $number)
{
  if ($number != $missingNumber)  $randomString .= (string)$number;
  $expectedString .= (string)$number;
}

// ********  Random string ready *******
//Count the digits in each array
for ($d=0;$d<=9;$d++)
{
  $difference = substr_count($expectedString, (string)$d) - substr_count($randomString, (string)$d);
  $missingDigitsCount += $difference;
 for ($i=0;$i<$difference;$i++)
 {
   $candidateNumber.= (string)$d; // This is the first iteration, we still have to get all the permutations for this string.
 }
}

if ($missingDigitsCount == 1) 
{
  echo "Solved because it is a single digit number: ". $candidateNumber . '<br>';;
}

if ($missingDigitsCount == 2)
{
  $permutations[0] = $candidateNumber;
  $permutations[1] = str_split($candidateNumber)[1] . str_split($candidateNumber)[0]; //Just interchange the digits
}

if ($missingDigitsCount == 3) // This is where it gets interesting as we should use all the permutations for the 3 digits which are 6 different permutations, I will just mix them directly instead of writing a function for simplicity
{
  $permutations[0] = $candidateNumber; // or in other words  str_split($candidateNumber)[0] . str_split($candidateNumber)[1] . str_split($candidateNumber)[2};
  $permutations[1] = str_split($candidateNumber)[0] . str_split($candidateNumber)[2] . str_split($candidateNumber)[1]; 
  $permutations[2] = str_split($candidateNumber)[1] . str_split($candidateNumber)[0] . str_split($candidateNumber)[2]; 
  $permutations[3] = str_split($candidateNumber)[1] . str_split($candidateNumber)[2] . str_split($candidateNumber)[0]; 
  $permutations[4] = str_split($candidateNumber)[2] . str_split($candidateNumber)[0] . str_split($candidateNumber)[1]; 
  $permutations[5] = str_split($candidateNumber)[2] . str_split($candidateNumber)[1] . str_split($candidateNumber)[0]; 
}

//cleanup the permutations we dont want anything that starts with zero or that is higher than our max

foreach ($permutations as $p => $permutation)                                                                                
{
 if ((str_split($permutations[$p])[0] == 0) || ((int)$permutations[$p] > (int)$maxNumber)) 
  {
    unset($permutations[$p]);
  }
}
reset ($permutations);

//Cleanup Done
                                                                                  
if (count($permutations) == 1) 
{
  echo "Solved because we have only one valid permutation: ". current($permutations) . '<br>';
}
$found = false;

foreach ($permutations as $permutation)
{
  if ((int)$permutation <= 50 && substr_count($randomString, $permutation) < 3) { $found = true; echo 'The missing number is: '. $permutation. ' because there is less than three occurrences and the number is less or equal than 50 <br>';}
  if ((int)$permutation > 50 and (int)$permutation < 100  && substr_count($randomString, $permutation) < 2) { $found = true; echo 'The missing number is: ' . $permutation. ' because there is less than two occurrences and the number is between 50 and 100<br>';}
  if ((int)$permutation >= 100 && (int)$permutation <= $maxNumber && substr_count($randomString, $permutation) < 1) { $found = true; echo 'The missing number is: ' . $permutation. ' because there is no occurrences and the number is greater than 100<br>';}
}                                                                           

if (!$found)   {echo 'It was not possible to find the number using the current method.' .'<br>' ;}                                                                                                                                                         
                                                                                  
echo '$missingNumber: '. $missingNumber. '<br> <br>';
echo $randomString . '<br> <br>';
echo $expectedString . '<br> <br>';
echo 'missingDigits: '. $missingDigitsCount . '<br> <br>';
echo 'CANDIDATES:'.'<br> <br>';
var_dump($permutations);
