//g++ -std=c++11 dog.cpp `pkg-config --libs --cflags opencv4`
#include <iostream>  //入出力関連ヘッダ
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ
#include <time.h>//time_t用
#include <sstream>//ostringstream用
#include <iomanip>//ostringstream用
#include <vector>//ベクターサイズ取得用
#include <string>//テキストファイル取得用
#include <fstream>//テキストファイル出力用
#include "IPPJ.hpp"

//グローバル変数
std::vector <cv::Mat> output_imgs; //動的なMat型配列
std::vector <int> output_texts;

int main (int argc, const char* argv[]) {
    int ans1 = 160;
    int ans2 = 200;

    //入力画像の読み込み
    std::vector <cv::Mat> src_imgs; //動的Mat型配列
    src_imgs = IPPJInit(argc, argv); //関数呼び出し
    
    //----------以下，画像処理本体---------
    
    //②画像格納用インスタンスの生成
    cv::Mat grayImage1;  //cv::Mat クラス
    cv::Mat grayImage2;  //cv::Mat クラス
    cv::Mat grayImage3;  //cv::Mat クラス
    cv::Mat binImage1;  //cv::Mat クラス
    cv::Mat binImage2;  //cv::Mat クラス

//    std::vector<cv::Mat> bgrImage(3);
//    cv::Mat binImage;

    //③ウィンドウの生成と移動
    cv::namedWindow("Source1");  //ウィンドウ生成
    cv::moveWindow("Source1", 0, 0);  //ウィンドウ移動
    cv::namedWindow("Source2");  //ウィンドウ生成
    cv::moveWindow("Source2", src_imgs[0].cols, 0);  //ウィンドウ移動
    cv::namedWindow("Source3");  //ウィンドウ生成
    cv::moveWindow("Source3", src_imgs[0].cols+src_imgs[1].cols, 0);  //ウィンドウ移動
    cv::namedWindow("Gray1");    //ウィンドウ生成
    cv::moveWindow("Gray1", 0, 500);  //ウィンドウ移動
    cv::namedWindow("Gray2");    //ウィンドウ生成
    cv::moveWindow("Gray2", src_imgs[0].cols, 500);  //ウィンドウ移動
    cv::namedWindow("Gray3");    //ウィンドウ生成
    cv::moveWindow("Gray3", src_imgs[0].cols+src_imgs[1].cols, 500);  //ウィンドウ移動


    //④画像処理
    cv::cvtColor(src_imgs[0], grayImage1, cv::COLOR_BGR2GRAY);//変換
    cv::cvtColor(src_imgs[1], grayImage2, cv::COLOR_BGR2GRAY);//変換
    cv::cvtColor(src_imgs[2], grayImage3, cv::COLOR_BGR2GRAY);//変換

//    cv::split(sourceImage, bgrImage);//分離
    cv::threshold(grayImage2, binImage1, 100, 255, cv::THRESH_BINARY);
    cv::threshold(grayImage3, binImage2, 160, 255, cv::THRESH_BINARY);


    //⑥キー入力待ち
//    cv::waitKey(0);

//    //⑦画像の保存
    //出力画像の取得(今は手動)
    output_imgs.push_back(binImage1);
    output_imgs.push_back(binImage2);
    output_texts.push_back(ans1);
    output_texts.push_back(ans2);
    
    //出力用関数
    IPPJOutputImg(output_imgs);
    IPPJOutputText(output_texts);
    
    return 0;
}

