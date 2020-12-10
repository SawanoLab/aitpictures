//
//  main.cpp
//  gaussian
//
//  Created by x17070xx on 2018/05/22.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_7/image/tanbo.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME1 "result.jpg"
#define FILTER_SIZE (5) //フィルタサイズ

int main(int argc, const char * argv[]) {
    
    //1. 画像をグレースケールで入力
    cv::Mat src_img = cv::imread(FILE_NAME, 0);
    if(src_img.empty()){ //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return(-1);
    }
    
    //2. メモリ確保
    cv::Mat dst_img; //OpenCVはメモリを確保してくれる。ただし、画素アクセスの場合は不可
    
    //3. ガウシアンフィルタ
    cv::GaussianBlur(src_img, dst_img, cv::Size(FILTER_SIZE, FILTER_SIZE), 0);
    
    //4. 表示
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, dst_img);
    
    //キー入力待ち
    cv::waitKey();
    return 0;
}
