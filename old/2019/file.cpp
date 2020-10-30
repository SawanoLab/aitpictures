//g++ dip01.cpp `pkg-config --cflags opencv --libs opencv`
// #include <iostream>  //c++専用
#include <stdio.h> //cも使えるけど遅い
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ

#include "IPPJ.hpp"

int main (int argc, const char* argv[]) { //argc…プログラムの引数の数,　argv…プログラムの引数


    //①画像ファイルの読み込み
    cv::Mat src_img; //画像の型と変数
    src_img = cv::imread(argv[1]); //画像の読み込み
    if (src_img.empty()) { //入力失敗の場合
        fprintf(stderr, "読み込み失敗\n");
        return (1);
    }

    /* 参考　http://f-penguin.hatenablog.jp/entry/2016/06/07/192014 */

    // cv::Mat sourceImage = cv::imread("images/problem_img/group1/problem1/color.jpg", cv::IMREAD_COLOR);
    // if (sourceImage.data==0) {  //画像ファイルが読み込めなかった場合
    //     printf("File not found\n");
    //     exit(0);
    // }
    // printf("Width=%d, Height=%d\n", sourceImage.cols, sourceImage.rows);





    
    //②画像格納用インスタンスの生成
    // cv::Mat grayImage;
    // std::vector<cv::Mat> bgrImage(3); //bgrImage[0],bgrImage[1],bgrImage[2]
    
//    int i[10];
//    cv::Mat bgrImage[3];
//    std::vector<int> i;
    

    
    //③ウィンドウの生成と移動
    // cv::namedWindow("Source"); //ウィンドウ生成
    // cv::moveWindow("Source", 0,0);
    // cv::namedWindow("Gray");//ウィンドウ生成
    // cv::moveWindow("Gray", 400,0);
    // cv::namedWindow("B");//ウィンドウ生成
    // cv::moveWindow("B", 400,150);
    // cv::namedWindow("G");//ウィンドウ生成
    // cv::moveWindow("G", 400,300);
    // cv::namedWindow("R");//ウィンドウ生成
    // cv::moveWindow("R", 400,450);
    
    // //④画像処理
    // cv::cvtColor(sourceImage, grayImage, cv::COLOR_BGR2GRAY); //sorceImage→grayImage(グレースケール)
    // // cv::split(sourceImage,bgrImage); //sorceImage→bgrImage[0],bgrImage[1],bgrImage[2](分離)
    
    // //⑤ウィンドウへの画像の表示
    // cv::imshow("Source", sourceImage);
    // cv::imshow("Gray", grayImage);
    // // cv::imshow("B", bgrImage[0]);
    // // cv::imshow("G", bgrImage[1]);
    // // cv::imshow("R", bgrImage[2]);
    
    // //⑥キー入力待ち
    // cv::waitKey(0);


    //⑦画像の保存
    cv::Mat result_img;
    src_img.copyTo(result_img); //結果の画像
    
   
    // //出力画像の取得(今は手動)
    // cv::Mat output_imgs;
    // output_imgs.push_back(grayImage);
    
    // IPPJOutputImg(output_imgs);


    // //⑦画像の保存
    cv::imwrite(argv[2], result_img); //grayImageを"gray.jpg"ファイルとして保存

    
    return 0;
}

// ./a.out input_img1.jpg input_img2.jpg output_img.jpg
// argv[0]   argv[1]        argv[2]         argv[3]...