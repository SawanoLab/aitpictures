//
//  main.cpp
//  sobel
//
//  Created by x17070xx on 2018/05/22.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_8/image/ahiru.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    
    //1. 画像をグレースケールで入力
    cv::Mat src_img = cv::imread(FILE_NAME, 0);
    if(src_img.empty()){ //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return(-1);
    }
    
    //2. メモリ確保
    cv::Mat tmp_img; //一時的な画像
    cv::Mat sobel_img; //結果画像
    
    
    //3. ソーベルフィルタ（結果はfloat）
    cv::Sobel(src_img, tmp_img, CV_32F, 0, 1); //縦
    
    //4. 絶対値を取り強調かつ、８ビット（グレースケール）に変換
    cv::convertScaleAbs(tmp_img, sobel_img, 1, 0);
    
    //5. 表示
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, sobel_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, sobel_img);
    cv::waitKey(); //キー入力待ち（止める）
    
    return 0;
}

