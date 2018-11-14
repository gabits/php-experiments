<?php

require 'students_marks_for_module.php';


function get_data_for_html($file_contents) {
    // Given an array $file_contents, process the data to get all
    // information that will be exposed on the template.

    // The first line from the file contents should be the header information
    $file_header = clean_trailing_whitespaces_in_data_array($file_contents[0]);
    // And all other lines should involve student IDs and grades
    $file_body = clean_trailing_whitespaces_in_data_array($file_contents[1]);

    // First, generate and validate all data. The following logic retrieves 5
    // arrays with data for the HTML, then gather all in one major array
    $module_header = get_module_header($file_header);
    $raw_student_marks = get_student_marks($file_body);
    $valid_student_marks = validate_student_marks($raw_student_marks);
    $statistical_analysis = analyse_student_marks($valid_student_marks);
    $grade_distribution = calculate_grade_distribution($valid_student_marks);

    $html_data = array(
        'module_header' => $module_header,
        'raw_student_marks' => $raw_student_marks,
        'valid_student_marks' => $valid_student_marks,
        'statistical_analysis' => $statistical_analysis,
        'grade_distribution' => $grade_distribution,
    );
};


function build_and_display_html_from_file($data_file) {
    // Reads the file, validates the data and places it in the
    // HTML so we can display it to the user.

    function display_data_from_array() {
        echo "<p>";
        foreach ($array_data as $key => $value) {
            echo "<b>$key</b>: $value";
        }
        echo "</p>";
    };

    $file_contents = get_file_contents($data_file);
    $html_data = get_data_for_html($file_contents);

    $number_of_students = $html_data['number_of_students'];

    echo "<section>";

    echo "<h2>Module Header Data...</h2>";
    display_data_from_array($html_data["module_header"]);

    echo "<h2>Student ID and Mark data read from file... </h2>";
    display_data_from_array($html_data["raw_student_marks"]);

    echo "<h2>ID's and module marks to be included...</h2>";
    display_data_from_array($html_data["valid_student_marks"]);

    echo "<h2>Statistical Analysis of module marks...</h2>";
    display_data_from_array($html_data["statistical_analysis"]);

    echo "<h2>Grade Distribution of module marks... </h2>";
    display_data_from_array($html_data["grade_distribution"]);

    echo "</section>";

    echo "<span>---------------------------------------------</span>";
};

?>