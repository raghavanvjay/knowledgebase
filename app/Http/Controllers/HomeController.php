<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home($name = "VJ")
    {
        return view('userhome', compact("name"));
    }

    /**
     * Display results of a test function
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $name - Default Param
     *
     * @return Illuminate\View\View
     */
    public function codeSample($name = "VJ")
    {
        // $seed=11;
        // $result = $this->drawPattern($seed);

        $players = ['A', 'B', 'C', 'D'];
        $dieRolls=[
            [3, 4, 6, 2],
            [1, 2, 3, 4],
            [6, 6, 1, 6]
        ];
        $result = $this->trackPositions($dieRolls, $players);

        // Ticket sales - process requests
        // $ticketRequests = [6, 5, -3, -4];
        // $result = $this->ticketSales($ticketRequests);

        // Strip Strings
        // $thresholdLength = 4;
        // $inputStr = "strip out all words greater than +n";
        // $result = $this->stripString($inputStr, $thresholdLength);

        // Evaluate string expression
        // $exprStr = '150-50-50-50-50';
        // $result = $this->evaluateExpression($exprStr);

        // Sorting sentences by vowel count
        // $sentences = [
        //     0 => "analyse fundamental technical strength and understanding",
        //     1 => "effective determination of technical proficiency",
        //     2 => "common pitfall is to focus too heavily on technical minutia",
        //     3 => "communicate clearly and effectively, both verbally and in writing"
        // ];
        // $result = $this->sortSentencesByVowelCount($sentences);

        // Kings moves in Chess
        // $result = $this->kingMoves("A8");

        return view('userhome', compact("name", "result"));
    }

    /**
     * started 15:40
     * Track position of players based on die rolls
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param array $dieRolls 2D array representing die rolls
     * @param array $players 1D array with player names
     *
     * @return array
     */
    public function trackPositions($dieRolls, $players)
    {
        $i=0;
        $playerPositions[$i] = [1, 1, 1, 1];
        $playerPositions[$i]["comment"] = "Initial position";
        foreach($dieRolls as $round) {
            foreach ($round as $key=>$roll) {
                $comment = $players[$key] . ' rolls ' . $roll;
                $playerPositions[++$i] = $playerPositions[$i-1];
                $playerPositions[$i][$key] = $playerPositions[$i-1][$key] + $roll;
                $opponent = array_search($playerPositions[$i][$key], $playerPositions[$i-1]);
                if ($opponent !== false) {
                    $playerPositions[$i][$opponent] = 1;
                    $comment .= '; resets ' . $players[$opponent];
                }
                $playerPositions[$i]['comment']= $comment;
            }
        }
        return $playerPositions;
    }

    //@note to be completed
    public function bestFit($booksArray, $fullLength) {
        // order numbers in ascending order
        //
        if (array_sum($booksArray) <= $fullLength) {
            return $booksArray;
        }

        foreach($booksArray as $name=>$length) {
            if ($length > $fullLength) {
                continue;
            } else {
                $set[$name] = $length;
                $subArray = array_diff_assoc($booksArray, [$name => $length]);
                $setLength = $length;
                foreach($subArray as $subName=>$subLength) {
                    if ($setLength + $subLength > $fullLength) {
                        break;
                    }
                    $set[$subName] = $set[$subLength];
                }
            }
        }

        $validSets = $this->getValidSets($booksArray, $fullLength);
        foreach($validSets as $validSet) {
            //Find array with max counts;
        }
    }


    /**
     * Return status messages for ticket requests
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param array $ticketRequests - integer array
     *
     * @return array of status messages
     */
    public function ticketSales ($ticketRequests)
    {
        $total = $remaining = 10;
        foreach ($ticketRequests as $requested) {
            if ($requested < 0) {
                $requested = -$requested;
                if ($requested > ($total - $remaining)) {
                    $status = "Request for cancelling $requested tickets denied; sold " . ($total-$remaining);
                } else {
                    $remaining += $requested;
                    $status = "Request for cancelling $requested tickets approved";
                }
            } else {
                if ($requested > $remaining) {
                    $status = "Request for $requested tickets denied";
                } else {
                    $remaining -= $requested;
                    $status = "Request for $requested tickets approved";
                }
            }
            $result[] = $status . "; remaining $remaining";
        }
        return $result;
    }

    /**
     * Evaluate expression in string format; allowed operators: + and -
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $exprStr
     *
     * @return int $result
     */
    public function evaluateExpression($exprStr)
    {
        $result = 0;
        $exPlus = explode('+', $exprStr);
        foreach($exPlus as $plusPiece)
        {
            $exMinus = explode('-', $plusPiece);
            $minResult = $exMinus[0];
            unset($exMinus[0]);
            foreach($exMinus as $minusPiece) {
                $minResult -= $minusPiece;
            }
            $result += $minResult;
        }
        return $result;
    }

    /**
     * Evaluate expression in string format; allowed operators: +, - and *
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $exprStr
     *
     * @return int $result
     */
    public function evaluateExpression2($exprStr)
    {
        $result = 0;
        $exPlus = explode('+',$exprStr);
        foreach($exPlus as $index=>$plusPiece)
        {
            $exMinus = explode('-', $plusPiece);
            foreach($exMinus as $index => $minusPiece) {
                $exMult = explode('*', $minusPiece);
                $multResult = 1;
                foreach($exMult as $multPiece) {
                    $multResult *= $multPiece;
                }
                if ($index === 0) {
                    $minResult = $multResult;
                } else {
                    $minResult -= $multResult;
                }
            }
            $result += $minResult;
        }
        return $result;
    }

    /**
     * Given an array of sentences, sort them by
     * count of vowels in them, in descending order
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param type  description
     *
     * @return void
     */
    public function sortSentencesByVowelCount($sentences)
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        $result = [];
        //for each sentence, find the count of vowels in it
        foreach($sentences as $sentence) {
            $parse = strtolower($sentence);
            $len = strlen($parse);
            $vowelCount = 0;
            for ($i=0;$i<$len;$i++) {
                if (in_array($parse[$i], $vowels)) {
                    $vowelCount++;
                }
            }
            $result[] = [
                'vowelCount' => $vowelCount,
                'sentence' => $sentence
            ];
        }

        //sort the sentences by $vowelCount
        do {
            $max = 0;
            foreach ($result as $index=>$sentence) {
                if ($sentence['vowelCount'] > $max) {
                    $max = $sentence['vowelCount'];
                    $maxIndex = $index;
                }

            }
            $finalResult[] = $result[$maxIndex]['sentence'] . '(' . $result[$maxIndex]['vowelCount'] . ')';
            unset($result[$maxIndex]);
        } while (!empty($result));

        return $finalResult;
    }

    /**
     * Find the legal moves for a King, given the starting position on chess board
     * Assume no positions are blocked by own or enemy pieces
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $startPosition - A1 to H8
     *
     * @return string $result - valid positions - A2, B2, B1
     */
    public function kingMoves($startPosition)
    {
        $f = strtoupper($startPosition[0]);
        $r = $startPosition[1];
        $allowed_files = range("A", "H");

        if ($r >= 1 and $r <=8 and in_array($f, $allowed_files))
        {
            $k = array_search($f, $allowed_files);
            $result_files[] = $k;
            if ($k > 0) {
                $result_files[] = $k-1;
            }
            if ($k < 7) {
                $result_files[] = $k+1;
            }

            $result_rows[] = $r;
            if ($r > 1)
                $result_rows[] =  $r-1;
            if ($r < 8)
                $result_rows[] = $r+1;
            asort($result_files);
            asort($result_rows);
            foreach ($result_files as $rf) {
                foreach ($result_rows as $rr) {
                    $result[] = $allowed_files[$rf] . $rr;
                }
            }
            if ($k = array_search($startPosition, $result)) {
                unset($result[$k]);
            }
            return implode (', ', $result);
        }
        else
        {
          return "Invalid position";
        }
    }

    /**
     * Strip strings into important keywords
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $inputStr original string input
     * @param int $threshold minimum string length
     *
     * @return string
     */
    public function stripString($inputStr, $threshold)
    {
        $words = explode(' ', $inputStr);
        $result = [];
        foreach($words as $word) {
            if($word[0] == '+') {
                $word = substr($word, 1);
            } elseif ($word[0] == '-' || strlen($word) < $threshold) {
                $word = false;
            }
            if ($word && !in_array($word, $result)) {
                $result[] = $word;
            }
        }
        return implode(' ', $result);
    }

    /**
     * Draw single pattern line
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param int $seed
     * @param int $blanks no. of initial blank spots
     *
     * @return string
     */
    public function drawPatternLine($seed, $blanks)
    {
        $patternStr = '';
        for ($i=0; $i<$seed; $i++) {
            if ($i < $blanks) {
                $patternStr .= '&nbsp;&nbsp;&nbsp;';
            } else if($i >= ($seed - $blanks)) {
                break;
            } else {
                $patternStr .= '&nbsp;|&nbsp;';
            }
        }
        $patternStr .= '<br>';
        return $patternStr;
    }

    /**
     * Draw the whole pattern as requested
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param int $seed
     *
     * @return string
     */
    public function drawPattern($seed)
    {
        $blanks = 0;
        $pattern = '';
        while(($seed - ($blanks*2)) > 0) {
            $pattern .= $this->drawPatternLine($seed, $blanks);
            $blanks++;
        }

        $blanks--;

        while($blanks >= 0) {
            $pattern .= $this->drawPatternLine($seed, $blanks);
            $blanks--;
        }
        return $pattern;
    }
}
