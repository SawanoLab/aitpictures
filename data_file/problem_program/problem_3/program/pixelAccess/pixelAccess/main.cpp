//
//  main.cpp
//  imgWaku
//
//  Created by x17070xx on 2018/04/21.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>

#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_3/image/whiterose.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    int x, y;
    
    cv::Mat src_img = cv::imread(FILE_NAME);
    if (src_img.empty()) {
        return (-1);
    }
    
    cv::Mat dst_img = cv::Mat(src_img.size(), CV_8UC3);
    
    for (y=0; y<src_img.rows; y++) {
        for (x=0; x<src_img.cols; x++){
            
            cv::Vec3b s = src_img.at<cv::Vec3b>(y, x);
            s[0] = s[0];
            s[1] = s[1];
            s[2] = s[2];
            
            
            if (x<=9 || x>=src_img.cols-10 || y<=9 || y>= src_img.rows-10) { //xyの最初と最後（0スタートより最後は-1）
                s[0] = 0;
                s[1] = 0;
                s[2] = 0;
                //黒くする
            }else{
                s[0] = s[0];
                s[1] = s[1];
                s[2] = s[2];
                //元のまま
            }
            dst_img.at<cv::Vec3b>(y, x) = s;
        }
    }
    
    cv::imshow(WINDOW_NAME_INPUT, src_img);
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img);
    cv::imwrite(SAVE_FILE_NAME1, dst_img);
    
    cv::waitKey();
    return 0;
}


