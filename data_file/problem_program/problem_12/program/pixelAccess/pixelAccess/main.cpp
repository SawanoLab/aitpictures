//
//  main.cpp
//  morphology
//
//  Created by x17070xx on 2018/06/19.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>

//画像ファイル
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_17/image/cat.jpg"

//ウィンドウ名
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    //画像をグレースケールで入力
    cv::Mat src_img = cv::imread(FILE_NAME, 0);
    if (src_img.empty()) { //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return (-1);
    }
    cv::Mat bin_img = cv::Mat(src_img.size(), CV_8UC1);
    cv::Mat dst_img = cv::Mat(src_img.size(), CV_8UC1);
    cv::Mat result_img = cv::Mat(src_img.size(), CV_8UC1);
    //二値化
    cv::threshold(src_img, bin_img, 100, 255, cv::THRESH_BINARY);
    int i;
    //膨張
//    for (i=0; i<5; i++) {
//        cv::dilate(bin_img, dst_img, cv::Mat(), cv::Point(-1, -1), i);
//        cv::imshow(WINDOW_NAME_OUTPUT, dst_img);
//        cv::imwrite(SAVE_FILE_NAME1, dst_img);
//
//    }
    //収縮
    for (i=0; i<7; i++) {
        cv::erode(bin_img, result_img, cv::Mat(), cv::Point(-1, -1), i);
        cv::imshow(WINDOW_NAME_OUTPUT, result_img);
        cv::imwrite(SAVE_FILE_NAME1, result_img);
    }
    
    cv::waitKey();
    return 0;
}
