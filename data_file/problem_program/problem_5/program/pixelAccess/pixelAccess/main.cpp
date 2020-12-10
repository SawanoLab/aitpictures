//
//  main.cpp
//  posterization
//
//  Created by x17070xx on 2018/04/24.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <iostream>
#include <opencv2/opencv.hpp>

#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_5/image/skytree.jpg"
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define COLOR_NUM 256
#define SAVE_FILE_NAME1 "result.jpg"

int main(int argc, const char * argv[]) {
    int x, y, i;
    
    //画像の入力
    cv::Mat src_img = cv::imread(FILE_NAME,0);
    if(src_img.empty()) { //入力失敗の場合
        return(-1);
    }
    //出力画像のメモリ確保（グレースケール）
    cv::Mat dst_img = cv::Mat(src_img.size(), CV_8UC1);

    unsigned char lut[COLOR_NUM]; //ルックアップテーブル
    //ルックアップテーブルの生成（４段階）

    for(i=0; i<COLOR_NUM; i++){
        if(i<=63){
            lut[i]=0;
        }else if(64<=i && i<=127){
            lut[i]=85;
        }else if(128<=i && i<=191){
            lut[i]=170;
        }else{
            lut[i]=255;
        }
    }

    //画素の走査
    for(y=0; y<dst_img.rows; y++){
        for(x=0; x<dst_img.cols; x++){
            //画素値の取得
            unsigned char s = src_img.at<unsigned char>(y, x);
            //ルックアップテーブルによるポスタリゼーション
            dst_img.at<unsigned char>(y, x)=lut[s];
        }
    }

    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img); //画像の表示
    cv::imwrite(SAVE_FILE_NAME1, dst_img);
    cv::waitKey(); //キー入力待ち（止める）
    return 0;
}
