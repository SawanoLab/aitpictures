//
//  main.cpp
//  alpha
//
//  Created by x17070xx on 2018/05/29.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>
#define FILE_NAME1 "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_10/image/view1.jpg"
#define FILE_NAME2 "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_10/image/view2.jpg"
#define ALPHA (0.5) //透過度
//ウィンドウ名
#define WINDOW_NAME_INPUT1 "input1"
#define WINDOW_NAME_INPUT2 "input2"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"


int main(int argc, const char * argv[]) {
    
    //画像をグレースケールで入力
    cv::Mat src_img1 = cv::imread(FILE_NAME1, 0);
    cv::Mat src_img2 = cv::imread(FILE_NAME2, 0);
    if(src_img1.empty() || src_img2.empty() ){ //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return(-1);
    }

    cv::Mat result_img = cv::Mat(src_img1.size(), CV_8UC1);
    int x, y;
    
    //合成画像の出力
    for(y=0; y<src_img1.rows; y++){
        for(x=0; x<src_img1.cols; x++){
            
            //画素値の取得(double型)
            double s1 = (double)src_img1.at<unsigned char>(y, x);
            double s2 = (double)src_img2.at<unsigned char>(y, x);
            int s_result = ALPHA * s1 + (1.0 - ALPHA) * s2;
            result_img.at<unsigned char>(y, x) = (unsigned char)s_result;
        }
    }
 
    //表示
    cv::imshow(WINDOW_NAME_INPUT1, src_img1); //画像の表示
    cv::imshow(WINDOW_NAME_INPUT2, src_img2); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, result_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, result_img);
    //キー入力待ち
    cv::waitKey();
    return 0;
}
