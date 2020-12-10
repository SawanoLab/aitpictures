//
//  main.cpp
//  pixelAccess
//
//  Created by x17070xx on 2018/04/17.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>

#include <stdlib.h>
#include <math.h>

//画像ファイル（小さめが良い）
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_4/image/orangerose.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    
    //画像の入力
    cv::Mat src_img = cv::imread(FILE_NAME);
    if(src_img.empty()) { //入力失敗の場合
        return(-1);
    }
    
    //出力画像のメモリ確保
    cv::Mat dst_img = cv::Mat(src_img.size(), CV_8UC3);
    
   double mx,my;
    
    mx=src_img.cols/2; //中心座標を求める
    my=src_img.rows/2; //中心座標を求める
    
    cv::Vec3b s;
    for (int y=0; y<src_img.rows; y++) {
        for (int x=0; x<src_img.cols; x++) {
            s = src_img.at<cv::Vec3b>(y, x);
            cv::Vec3i s1; //int型の3要素配列s1
            
            double x1,y1;
            x1=fabs(mx-x)*0.5;
            y1=fabs(my-y)*0.5;
            
            s1[0]=s[0]-x1-y1; //x,yの値が大きい程，s1[0]の値も大きくなる
            s1[1]=s[1]-x1-y1; //x,yの値が大きい程，s1[1]の値も大きくなる
            s1[2]=s[2]-x1-y1; //x,yの値が大きい程，s1[2]の値も大きくなる
            s=s1; //int型をunsignedchar型に丸める
            dst_img.at<cv::Vec3b>(y, x) = s;
            
        }
    }
    
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, dst_img);
    
    cv::waitKey(); //キー入力待ち（止める）
    return 0;
}
