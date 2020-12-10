//
//  main.cpp
//  median
//
//  Created by x17070xx on 2018/05/29.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_9/image/key.jpg"
//ウィンドウ名
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define FILTER_SIZE (7) //フィルタサイズ(3以上の奇数)
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    
    //画像をグレースケールで入力
    cv::Mat src_img = cv::imread(FILE_NAME, 0);
    if(src_img.empty()){ //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return(-1);
    }
    

    cv::Mat median_img; //出力画像の宣言
    //メディアンフィルタ　（入力、出力、フィルタサイズ）
    cv::medianBlur(src_img, median_img, FILTER_SIZE);
    // 表示
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, median_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, median_img);
    cv::waitKey(); //キー入力待ち（止める）
    
    return 0;
}
