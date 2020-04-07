//g++ -std=c++11 dog.cpp `pkg-config --libs --cflags opencv4`
#include <iostream>  //入出力関連ヘッダ
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ
#include <time.h>//time_t用
#include <sstream>//ostringstream用
#include <iomanip>//ostringstream用
#include <vector>//ベクターサイズ取得用
#include <string>//テキストファイル取得用
#include <fstream>//テキストファイル出力用

//画像を取得
std::vector <cv::Mat> IPPJInit(int argc, const char *argv[]);

int main (int argc, const char* argv[]) {
    //入力画像の読み込み
    std::vector <cv::Mat> src_imgs; //動的Mat型配列
    cv::Mat teacher_img;//教師画像
    cv::Mat abs_img;//比較画像
    
    cv::Mat img1;//教師画像
    cv::Mat img2;//教師画像
//    img1 = cv::imread("img2.jpg", cv::IMREAD_COLOR);
//    img2 = cv::imread("img3.jpg", cv::IMREAD_COLOR);
//
    
    src_imgs = IPPJInit(argc, argv); //関数呼び出し
    teacher_img = cv::imread("images/problem_img/group1/problem1/teacher.jpg", cv::IMREAD_COLOR); //教師画像読み込み
    
//    cv::namedWindow("Source1");  //ウィンドウ生成
//    cv::moveWindow("Source1", 0, 0);  //ウィンドウ移動
//    cv::namedWindow("Source2");  //ウィンドウ生成
//    cv::moveWindow("Source2", 200, 0);  //ウィンドウ移動
    
    
    //出力画像とお手本画像の比較
    unsigned char intensity;
    int sum=0;
    cv::absdiff(src_imgs[0], teacher_img, abs_img);
    /* 「cv::absdiff(比較画像1, 比較画像2, 結果画像)」を使うことで、画像同士の差分を取得 */
//
//    cv::absdiff(img1, img2, abs_img);
//
//    cv::imshow("Source1", abs_img);
//    cv::waitKey(0);
//
    for(int y = 0; y < abs_img.rows; ++y){
        for(int x = 0; x < abs_img.cols; ++x){
            intensity = abs_img.at<unsigned char>(y, x); //X座標がx, Y座標がyに位置するピクセルの値を取得
            sum += intensity;
        }
    }
//
//    cv::imshow("Source1", src_imgs[0]);
//    cv::imshow("Source2", teacher_img);
//
//        cv::imshow("Source1", img1);
//        cv::imshow("Source2", img2);
//
//    printf("111");
    printf("%d", sum);
    //⑥キー入力待ち
//    cv::waitKey(0);

    return 0;
}

std::vector <cv::Mat> IPPJInit(int argc, const char *argv[]){
    //画像ファイルの読み込み
    cv::Mat sourceImage;
    std::vector <cv::Mat> src_imgs; //動的なMat型配列
    for (int i=1; i<argc; i++) { //argvを使って読み込み
        sourceImage = cv::imread(argv[i], cv::IMREAD_COLOR);
        if (sourceImage.data==0) {  //画像ファイルが読み込めなかった場合
            printf("%d番目の", i);
            printf("画像ファイルが見つかりません\n\n");
            exit(0);//これより後ろに書かれた画像の有無は不明
        }
        src_imgs.push_back(sourceImage);
    }
    return src_imgs;
}
