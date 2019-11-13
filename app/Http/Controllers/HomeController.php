<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Dummy home page, with a welcome title and boiler plate text
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $name
     *
     * @return Illuminate\View\View
     */
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
        // Single board move - with start position and single move
        // $startPosition = 'B4';
        // $move = 'L2';
        // $result = $this->singleBoardMove($startPosition, $move);

        // Draw pattern like X, given a seed
        $seed=11;
        $result = $this->drawPattern($seed);

        // Roll dice and get player positions
        // $players = ['A', 'B', 'C', 'D'];
        // $dieRolls=[
        //     [3, 4, 6, 2],
        //     [1, 2, 3, 4],
        //     [6, 6, 1, 6]
        // ];
        // $result = $this->trackPositions($dieRolls, $players);

        // Multiple board movement instructions, with min/max boundary setting
        // $moves = ['R1', 'L2', 'U2', 'D3', 'D4', 'L1', 'R3'];
        // $startPosition = 'B4';
        // $minPosition = 'A1';
        // $maxPosition = 'D4';
        // $result = $this->boardMovement($startPosition, $moves, $minPosition, $maxPosition);

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
     * Function to return move detail given start position and move instruction
     * @note Started 15:10 to 15:30
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $startPos - A1 to D4
     * @param string $move - 2 letter string like L3 for move left 3 squares
     * R - right, U - up, D - down
     *
     * @return string
     */
    public function singleBoardMove($startPos, $move)
    {
        $currentPos = $startPos;
        $minPos = "A1";
        $maxPos = "D4";
        $moveLength = (int)$move[1];
        $valid = false;
        $direction = [
            'U' => 'up',
            'D' => 'down',
            'L' => 'left',
            'R' => 'right'
        ];
        switch($move[0]){
            case 'U':
                if (($currentPos[1] - $minPos[1]) >= $moveLength) {
                    $currentPos[1] = $currentPos[1] - $moveLength;
                    $valid = true;
                }
            break;
            case 'D':
                if (($maxPos[1] - $currentPos[1]) >= $moveLength) {
                    $currentPos[1] = $currentPos[1] + $moveLength;
                    $valid = true;
                }
            break;
            case 'R':
                if ((ord($maxPos[0]) - ord($currentPos[0])) >= $moveLength) {
                    $currentPos[0] = chr(ord($currentPos[0]) + $moveLength);
                    $valid = true;
                }
            break;
            case 'L':
                if ((ord($currentPos[0]) - ord($minPos[0])) >= $moveLength) {
                    $currentPos[0] = chr(ord($currentPos[0]) - $moveLength);
                    $valid = true;
                }
            break;
        }
        if (! $valid) {
            $currentPos = "invalid";
        }
        return sprintf("%s => move %s %d squares => %s", $startPos, $direction[$move[0]], $moveLength, $currentPos);

    }

    /**
     * Started 11:30 - 11:56
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param string $startPos - A1 to Z9
     * @param array $moves - array of moves L, R, U, D
     * @param string $minPos - A1 to Z9
     * @param string $maxPos - A1 to Z9
     *
     * @return array('start', 'end', 'moves', 'invalid')
     */
    public function boardMovement($startPos, $moves, $minPos='A1', $maxPos='D4')
    {
        $currentPos = $startPos;
        $invalidMoves = [];
        foreach($moves as $key=>$move) {
            $valid = false;
            $moveLength = (int)$move[1];
            switch($move[0]){
                case 'U':
                    if (($currentPos[1] - $minPos[1]) >= $moveLength) {
                        $currentPos[1] = $currentPos[1] - $moveLength;
                        $valid = true;
                    }
                break;
                case 'D':
                    if (($maxPos[1] - $currentPos[1]) >= $moveLength) {
                        $currentPos[1] = $currentPos[1] + $moveLength;
                        $valid = true;
                    }
                break;
                case 'R':
                    if ((ord($maxPos[0]) - ord($currentPos[0])) >= $moveLength) {
                        $currentPos[0] = chr(ord($currentPos[0]) + $moveLength);
                        $valid = true;
                    }
                break;
                case 'L':
                    if ((ord($currentPos[0]) - ord($minPos[0])) >= $moveLength) {
                        $currentPos[0] = chr(ord($currentPos[0]) - $moveLength);
                        $valid = true;
                    }
                break;
            }
            if (! $valid) {
                $invalidMoves[$key] = $move;
            }
        }
        return (['start' => $startPos, 'end' => $currentPos, 'invalid' => $invalidMoves, 'moves' => $moves]);
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

    /**
     * Best fit - MT question solution
     * Given a shelf of length l, and array of books with width
     * find the set of books that best fit the shelf
     *
     * @author VijayK <vk@lbit.in>
     *
     * @param array $booksArray('name', 'length')
     * @param float $fullLength - length of shelf
     *
     * @return array - set of books that best fit the shelf
     * @note to be completed
     */
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
