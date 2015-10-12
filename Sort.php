<?php
/**
 * Sorting Algorithms .
 *
 * Author :Cleve Gomes
 * Date : October 12 2015
 *
 *
 */


try{
    if($argc < 2)
    {
        /**
         * No file given throw exception
         */
        throw new Exception("Sample input file not given");
    }

    /**
     * File does not exist throw exception
     */
    if(!file_exists($argv[1]))
        throw new Exception("Sample input file not found");
    $fd = fopen($argv[1],"r");
    $line = trim(fgets($fd));
    fclose($fd);


    $values = [NULL, FALSE, '', 0, 1];

    function myFilter($var){
        return ($var !== NULL && $var !== FALSE && $var !== '');
    }





    $unsortedary = array_values(array_filter(explode(" ",$line),'myFilter'));

    print_r("\nInput String->".$line."\n");

    $unsortedary2 = $unsortedary;
    $retarry = QuickSort($unsortedary2,0,(sizeof($unsortedary)-1));
    print_r("\nQuick Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n log n,Avg->n log n,Worst->n2\n";

    $retarry = MergeSort($unsortedary);
    print_r("\nMerge Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n log n,Avg->n log n,Worst->n log n\n";


    $retarry = InsertionSort($unsortedary);
    print_r("\nInsertion Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n,Avg->n2,Worst->n2\n";


    $retarry = SelectionSort($unsortedary);
    print_r("\nSelection Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n2,Avg->n2,Worst->n2\n";


    $retarry = BubbleSort($unsortedary);
    print_r("\nBubble Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n,Avg->n2,Worst->n2\n";


    $retarry = HeapSort($unsortedary);
    print_r("\nHeap Sort Output String->".implode(' ',$retarry)."\n");
    echo "Best->n logn,Avg->n logn,Worst->n logn\n";










}
catch(Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


/*
 * Heap Function. That builds a Max Heap
 */
function Heapify(&$unsortedArry,$parent,$child1,$child2,&$sortArry=array())
{


/*
 * if parent is already greater that children nodes or child not does not exit return back
 */
    if(($unsortedArry[$parent] > $unsortedArry[$child1]) && ($child2 == null || $unsortedArry[$parent] > $unsortedArry[$child2]))
    {
        return;
    }
    /**
     * child 1 is bigger than parent  swap child 1 with parent
     */
    if($child2 == null || $unsortedArry[$child1] > $unsortedArry[$child2])
    {
        if(!in_array($child1,$sortArry))
        {
            $swap = $unsortedArry[$parent];
            $unsortedArry[$parent] = $unsortedArry[$child1];
            $unsortedArry[$child1] = $swap;

            $newparent = $child1;


            $totalElements = sizeof($unsortedArry);
            $child1 =($newparent +1) +$newparent;
            $child2 = (($child1+1) <=($totalElements-1))?($child1+1):null;


            if($child1<=($totalElements-1))
                Heapify($unsortedArry,$newparent,$child1,$child2,$sortArry);
        }

    }
    /**
     * child 2 is bigger than parent swap the child2 with parent
     */
    else
    {

        if(!in_array($child2,$sortArry))
        {
            $swap = $unsortedArry[$parent];
            $unsortedArry[$parent] = $unsortedArry[$child2];
            $unsortedArry[$child2] = $swap;


            $newparent = $child2;

            $totalElements = sizeof($unsortedArry);
            $child1 =($newparent +1) +$newparent;
            $child2 = (($child1+1) <=($totalElements-1))?($child1+1):null;

            if($child1<=($totalElements-1))
                Heapify($unsortedArry,$newparent,$child1,$child2,$sortArry);

        }


    }


}

/**
 * Heap Sort
 * @param $unsortedArry
 * @return mixed   sorted Algorithm
 */
function HeapSort($unsortedArry)
{
    $totalElements = sizeof($unsortedArry);
    /**
     * Leaf nodes start from here
     */
    $leaveNodesKeyStart = ceil(($totalElements -1)/2);

    /*
     * non leave nodes end here
     */
    $noleaveNodeKeyEnd = 	$leaveNodesKeyStart -1;


    /**
     * Processing all non leaf nodes
     */
    while($noleaveNodeKeyEnd >=0)
    {
        /*
         * Find Children of the node
         */

        $child1 =($noleaveNodeKeyEnd +1) +$noleaveNodeKeyEnd;
        $child2 = (($child1+1) <=($totalElements-1))?($child1+1):null;

        /*
         * Building a Max Heap
         */
        Heapify($unsortedArry,$noleaveNodeKeyEnd,$child1,$child2);


        $noleaveNodeKeyEnd--;
    }






    $sortArry = Array();

/*
    * element starts from 0 there fore subtracting 1 from the count
    */
    $totalElements = $totalElements -1;

    while(($totalElements) >0)
    {

        /**
         * Swaping the greatest element on the Max Heap  to the last position on the tree
         */
        $swap =$unsortedArry[0];
        $unsortedArry[0] = $unsortedArry[$totalElements];
        $unsortedArry[$totalElements] = $swap;



        /*
         *  List of all sorted positions. that need not be processed in Heaping the array.
         */
        $sortArry[] =$totalElements;



        /*
         * Removing the last sorted value from future process
         */
        $totalElements--;

        /**
         * Leaf nodes start from below
         */
        $leaveNodesKeyStart = ceil(($totalElements)/2);

        /*
        * non leave nodes end here
        */
        $noleaveNodeKeyEnd = 	$leaveNodesKeyStart -1;


        /**
         * Processing all non leaf nodes
         */
        while($noleaveNodeKeyEnd >=0)
        {
            /*
             * Find Children of the node
             */
            $child1 = ($noleaveNodeKeyEnd + 1) + $noleaveNodeKeyEnd;
            $child2 = (($child1 + 1) <= ($totalElements)) ? ($child1 + 1) : null;


            /*
             * Building a Max Heap
            */

            Heapify($unsortedArry, $noleaveNodeKeyEnd, $child1, $child2, $sortArry);
            $noleaveNodeKeyEnd--;
        }





    }




return $unsortedArry;


}













/**
 * Bubble Sort
 * @param $unsortedArry
 * @return mixed  Sorted Array
 */

function BubbleSort($unsortedArry)
{

    /*
     * Size of the unsorted array
     */
    $arrySize = sizeof($unsortedArry);

    /**
     * Looping through the list to make sure every thing gets sorted
     */
    for($i=0;$i<($arrySize);$i++)
    {

        //Flag to check for swapping
        $swapflag = false;


        /**
         * Loop from start to the (end -(1 +i) ). Doing this because the last elements in the array are already
         * Sorted as the Algorithm  progresses
         */
        for($j=0;$j<($arrySize-(1+$i));$j++)
        {
            if($unsortedArry[$j] > $unsortedArry[($j+1)])
            {
                $swapflag = true;
                $swap = $unsortedArry[$j];
                $unsortedArry[$j] = $unsortedArry[($j+1)];
                $unsortedArry[($j+1)] = $swap;
            }
        }


        /**
         * If no swap was made in the previous iteration then the elements are already sorted and we can break from the loop.
         */
        if($swapflag == false)
        {

            break;
        }

    }

    /**
     * return the sorted Array
     */
    return $unsortedArry;


}










/**
 * Selection Sort
 * @param $unsortedArry
 * @return mixed   sorted Array
 */
function SelectionSort($unsortedArry)
{
    /*
     * size of the unsorted array
     */
    $asize = sizeof($unsortedArry);

    /**
     *  Processing the unsorted array
     */
    for($i=0;$i<$asize;$i++)
    {

        /**
         *  Setting $smallestValKey to -1 to
         */
        $smallestValue = $smallestValKey = -1;
        $j= $i;

        /*
         * Finding a smallest element in the unsorted section of the list
         */
        while($j < $asize)
        {
            /*
             * consequent finds in the unsorted list
             */
            if($smallestValKey != -1 )
            {


                if($unsortedArry[$j]< $smallestValue)
                {
                    $smallestValue = $unsortedArry[$j];
                    $smallestValKey = $j;
                }
            }
            /*
             * For the first find in the  unsorted section
             */
            else
            {
                $smallestValue = $unsortedArry[$j];
                $smallestValKey = $j;
            }

            $j++;
        }

        /**
         * if smallest element was found place it in the correct location
         */
        if($smallestValKey != -1)
        {

            $swap = $unsortedArry[$i];
            $unsortedArry[$i] = $smallestValue;
            $unsortedArry[$smallestValKey] = $swap;
        }



    }



    return $unsortedArry;
}







/**
 * Insertion Sort
 * @param $unsortedArry
 * @return mixed returns a sorted arrary
 */
function InsertionSort($unsortedArry)
{


    /**
     * Looping through the unsorted part of the unsorted array,for start index 0 is the sorted array
     */
    for($i=1;$i<sizeof($unsortedArry);$i++)
    {
        /*
         * The start index of the sorted part in the unsorted array
         */
        $idSorted = $i-1;

        /**
         * Picking one element from the unsorted array to sort it in the sorted part
         */
        $selval = $unsortedArry[$i];

        /**
         * Looping through the sorted part
         */
        while($idSorted >=0)
        {

            /**
             * Shifting the elements in the sorted array to make place for the new element
             */
            if($unsortedArry[$idSorted] > $selval)
            {


                $unsortedArry[$idSorted +1] = $unsortedArry[$idSorted];
                $unsortedArry[$idSorted] = $selval;



            }




            $idSorted--;
        }


    }


    /**
     * Returning the sorted array
     */
    return $unsortedArry;

}


/**
 * Quick Sort
 * @param $unsortedArry  unsorted array by reference
 * @param $startIndex  start index
 * @param $endIndex   end index
 * @return mixed  return sorted array
 * @throws Exception
 */
function QuickSort(&$unsortedArry,$startIndex,$endIndex)
{

    /**
     * Proceed to partition the unsorted array if start index is less than end index
     */
    if($startIndex < $endIndex)
    {

        /**
         * CAll to partition function
         */
        $wall =Partition($unsortedArry,$startIndex,$endIndex);


        /*
         * Calling its self recursively for elements in the Array less then the Wall and greater than the wall. The element on the wall is at its correct position
         */
        QuickSort($unsortedArry,$startIndex,($wall-1));
        QuickSort($unsortedArry,($wall+1),$endIndex);

    }

    return $unsortedArry;
}

/**
 *
 * Partitioning of the unsorted array
 * @param $unsortedArry by reference
 * @param $startIndex
 * @param $endIndex
 * @return mixed
 * @throws Exception
 */
function Partition(&$unsortedArry,$startIndex,$endIndex)
{

    /**
     * Making sure we have a valid array
     */
    if(sizeof($unsortedArry) > 0)
    {
        $current = $startIndex;
        /*
         * Wall is less then the current index
         */
        $wall= $current-1;
        /*
         * Selected to keep the pivot the last element of the array
         */
        $pivot = $endIndex;
        $lastElement = $endIndex;

        /**
         * iterating through the array
         */
        while($current < $lastElement)
        {

            /**
             * current value is <= than the pivot value
             */
            if($unsortedArry[$current]<=$unsortedArry[$pivot] )
            {

                /*
                 * Incrementing the wall swaping the wall and current value
                 */

                $wall++;
                $swap = $unsortedArry[$wall];

                $unsortedArry[$wall] = $unsortedArry[$current];

                $unsortedArry[$current] = $swap;


            }


            $current++;
        }


        /*
         *  Last increment the wall and swap the pivot with the wall
         */
        $swap = $unsortedArry[$wall+1];
        $unsortedArry[$wall+1] = $unsortedArry[$pivot];
        $unsortedArry[$pivot] = $swap;


        /**
         * return the wall
         */

        return $wall+1;
    }
    else
    {
        throw new Exception("Invalid unsorted Array in Quick Sort");
    }
}












/**
 * Merge Sort Algoritm
 * @param array $unsortedArry
 * @return array   Sorted Array
 * @throws Exception
 */
function MergeSort($unsortedArry = array())
{

    /**
     * Array is not empty
     */
    if(sizeof($unsortedArry) >1)
    {
        /**
         * selecting a mid to divide the array
         */
        $mid = sizeof($unsortedArry)/2;
        $leftarray = $rightarry = $newright= $newleft = array();

        /**
         * creating the left and right arrays
         */
        foreach($unsortedArry as $key => $val)
        {
            if($key <= ($mid-1))
                $leftarray[]= $val;
            else
                $rightarry[]= $val;
        }

        /**
         * Calling the Merge function on the left and right array
         */
        if(sizeof($leftarray)>0)
            $newleft =MergeSort($leftarray);

        if(sizeof($rightarry)>0)
            $newright = MergeSort($rightarry);



        $cntLeft = $cntRight = 0;
        $leftSize = sizeof($newleft);
        $rightSize  = sizeof($newright);
        $returnArry = array();

        /**
         * Actual Sorting
         *
         * Looping through the left array
         */
        while($cntLeft < $leftSize)
        {

            /**
             * Looping through the right array
             */
            while($cntRight < $rightSize)
            {
                /**
                 * Sorting of the array
                 */
                if($newleft[$cntLeft] <= $newright[$cntRight])
                {
                    $returnArry[]= $newleft[$cntLeft];
                    $cntLeft++;
                }
                else
                {
                    $returnArry[]= $newright[$cntRight];
                    $cntRight++;
                }
                break;
            }

            /**
             * Special case.that is the right array is completed. Then just copy the rest of the left array into the result.
             */
            if($cntRight == $rightSize)
            {
                $returnArry[]= $newleft[$cntLeft];
                $cntLeft++;
            }

        }


        /**
         * Special case. that is the left array is complete.Then just copy the rest of the right array into the result
         */
        if($cntRight < $rightSize)
        {
            $returnArry = array_merge($returnArry,array_slice($newright, $cntRight));

        }


        return $returnArry;


    }
    /*
     * Last element in the error
     */
    else if(sizeof($unsortedArry) ==1)
    {
        return $unsortedArry;

    }
    /**
     * Invalid Array
     */
    else
    {
        throw new Exception("Invalid unsorted Array in Merge Sort");
    }

}

?>