//
//  main.cpp
//  issue1_x17070
//
//  Created by x17070xx on 2018/06/05.
//  Copyright © 2018年 AIT. All rights reserved.
//

#include <opencv2/opencv.hpp>
#define FILE_NAME "/Applications/MAMP/htdocs/aitpictures_20/data_file/problem_program/problem_12/image/halo.jpg"
//ウインドウ名
#define WINDOW_NAME_INPUT "input"
#define WINDOW_NAME_OUTPUT "output"
#define SAVE_FILE_NAME "result.jpg"
#define THRESHOLD 0

#define COLOR_MAX (256)
int main(int argc, const char * argv[]) {
    //変数の宣言
    int i, x, y;//アクセス用の変数
    int sum=0;
    
    int hist[COLOR_MAX]; //ヒストグラム用配列
    
    //画像をグレースケールで入力
    cv::Mat src_img = cv::imread(FILE_NAME, 0);
    if(src_img.empty()){ //入力失敗の場合
        fprintf(stderr, "File is not opened.\n");
        return(-1);
    }
    cv::Mat dst_img;//出力画像
    
    //ヒストグラム用配列の初期化
    for(i=0; i<COLOR_MAX; i++){
        hist[i] = 0;
    }
    
    //閾値を求める
    
    //基準となる(p=10%)画素値を求める
    int s0 = (0.1 * src_img.rows * src_img.cols);
    //ヒストグラムの生成
    for(y=0; y<src_img.rows; y++){
        for(x=0; x<src_img.cols; x++){
            //画素値の習得
            unsigned char s = src_img.at<unsigned char>(y, x);//unsigned charは白黒の時
            
            hist[(int)s]++;//画素値の計算　　sはどんどん更新されるから、０−２５５にはなるが最終的な数字は最後の画素値になる
        }
    }
    
    //閾値の計算
    for(i=0; i<COLOR_MAX; i++){ //閾値
        sum += hist[i]; //画素値をたしていく
        if(sum >= s0) { //p＝１０のときを超えた場合
            printf("閾値は%dです\n", i);
            break; //終了
        }
    }
    
    //二値化
    cv::threshold(src_img, dst_img, i, 255, cv::THRESH_BINARY_INV); //白黒逆にする
    //出力
    cv::imwrite(SAVE_FILE_NAME, dst_img); //画像の保存
    cv::imshow(WINDOW_NAME_INPUT, src_img); //画像の表示
    cv::imshow(WINDOW_NAME_OUTPUT, dst_img); //画像の表示
    cv::waitKey(); //キー入力待ち（止める）
    return 0;
}
//友達に教えてもらい、解きました。
