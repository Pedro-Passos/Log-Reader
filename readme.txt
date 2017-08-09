****************************************************************************************
* This web app is designed to reads module mark files from a data sub-folder.          *
* It then builds a dynamic HTML page providing the Programme Director and Course       *
* Administrator with the information defined in the requirements below.                *
* Statistical information is required for each *.txt file, located in the data folder. *
****************************************************************************************

Documentation
-------------

1. For each set of module marks (file) display the following data:
    a. Module Code
    b. Module Title
    c. Tutor/Assessor name
    d. Date marking was done by the tutor
    e. Count of number of students who have been assessed
    f. Mean Mark
    g. Mode Mark
    h. Range
    i. Count of number of Distinctions
    j. Count of number of Merits
    k. Count of number of Passes
    l. Count of number of Fails
    m. Count of number of data errors
    n. A List of student IDs where there are data errors and the reason for the error;
    i. e.g. missing/incorrect student ID, missing/mark out of range
2. Display any of the following data errors if found:
    a. Module Code Invalid
    b. Missing module title, or contains non printable characters
    c. Missing tutor name, or contains non printable characters
    d. Invalid marking date
The module data files are in the following format:
    Any meaningful name with .txt extension
    Line 1: Module Code, Module Name, Tutor Name, Date marking done <end of line>
    Line 2 to end of file : Student ID, Module Mark <end of line>
    <end of file>

File coding specifications:
    Module Code (8 chars): 2 char code+4 char year (YYYY)+2 char term code (TN)
        2 char codes are:
        PP Problem Solving for Programming
        P1 Web Programming using PHP
        DT Introduction to Database Technology
        YYYY academic year; e.g. 1516, 1617, etc.
        TN T1, T2, or T3
    Date marks uploaded: DD/MM/YYYY
    Student ID: 8 digit integer
    Module Mark: Integer 0..100
Derivation of module mark classifications for Foundation Degrees
    Classification Mark Range
        Distinction 70+
        Merit 60-69
        Pass 40-59
        Fail <40
End