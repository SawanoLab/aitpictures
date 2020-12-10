//
//  main.cpp
//  pixelAccess
//
//  Created by x17070xx on 2018/04/17.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>

//画像ファイル（小さめが良い）
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_2/image/rose.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    int x, y;
    
    //画像の入力
    cv::Mat src_img = cv::imread(FILE_NAME);
    if(src_img.empty()) { //入力失敗の場合
        return(-1);
    }
    
    //出力画像のメモリ確保
    cv::Mat dst_img = cv::Mat(src_img.size(), CV_8UC3);
    
    //画像の走査
    for (y=0; y<src_img.rows; y++) {//縦方向
        for (x=0; x<src_img.cols; x++){ //横方向
            //画素値の取得
            cv::Vec3b s = src_img.at<cv::Vec3b>(y,x);
            s[0]  = s[0] + 100; //B
            s[1]  = s[1] + 100; //G
            s[2]  = s[2] + 100; //R
            dst_img.at<cv::Vec3b>(y, x) = s;
            
        }
    }
    
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, dst_img);
    
    cv::waitKey(); //キー入力待ち（止める）
    return 0;
}
