#include <iostream>  //入出力関連ヘッダ
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ
// #include "IPPJ.hpp"

#include <time.h>//time_t用
#include <sstream>//ostringstream用
#include <iomanip>//ostringstream用
#include <vector>//ベクターサイズ取得用
#include <string>//テキストファイル取得用
#include <fstream>//テキストファイル出力用



std::vector <cv::Mat> IPPJInit(int argc, const char *argv[]);//argv（画像名）の画像を読み込む
void IPPJOutputImg(std::vector <cv::Mat> output_imgs);//提出画像の名付け用


// void IPPJOutputText(std::vector <int> output_texts);//提出テキストの名付け用

// //argv（画像名）の画像を読み込む
// std::vector <cv::Mat> IPPJInit(int argc, const char *argv[]){
//     //画像ファイルの読み込み
//     cv::Mat sourceImage;
//     std::vector <cv::Mat> src_imgs; //動的なMat型配列
//     for (int i=1; i<argc; i++) { //argvを使って読み込み
//         sourceImage = cv::imread(argv[i], cv::IMREAD_COLOR);
//         if (sourceImage.data==0) {  //画像ファイルが読み込めなかった場合
//             printf("No.%d:", i);
//             printf("File not found\n\n");
//             exit(0);//これより後ろに書かれた画像の有無は不明
//         }
//         src_imgs.push_back(sourceImage);
//     }
//     return src_imgs;
// }
// /* 参考　http://f-penguin.hatenablog.jp/entry/2016/06/07/192014 */

//出力用
void IPPJOutputImg(std::vector <cv::Mat> output_imgs){ //コンパイルした画像output_imgs
    //現在時刻を取得
    time_t timer;
    struct tm *local;
    int year, month, day, hour, minute, second;
    timer = time(NULL);
    local = localtime(&timer);
    year = local->tm_year + 1900;
    month = local->tm_mon + 1;
    day = local->tm_mday;
    hour = local->tm_hour;
    minute = local->tm_min;
    second = local->tm_sec;
    
    //名前をつける
    char date[15];
    sprintf(date, "%04d%02d%02d%02d%02d%02d", year, month, day, hour, minute, second);//日付文字列を生成
    std::size_t size = output_imgs.size();
    for (int i=1; i<=size; i++) { //出力画像数だけ名付ける
        std::ostringstream oss;
        oss << date << "_" <<i;//ex:201908222230.jpg
        std::cout << oss.str() + ".jpg" << std::endl;//ex:201908222230.jpg
        cv::imwrite(oss.str() + ".jpg", output_imgs[i-1]);
    }
}

// void IPPJOutputText(std::vector <int> output_texts){
//     //テキストファイルを出力
//     time_t timer;
//     struct tm *local;
//     int year, month, day, hour, minute, second;
//     timer = time(NULL);
//     local = localtime(&timer);
//     year = local->tm_year + 1900;
//     month = local->tm_mon + 1;
//     day = local->tm_mday;
//     hour = local->tm_hour;
//     minute = local->tm_min;
//     second = local->tm_sec;
    
//     //名前をつける
//     char date[15];
//     sprintf(date, "%04d%02d%02d%02d%02d%02d", year, month, day, hour, minute, second);//日付文字列を生成
//     std::string str;
//     std::size_t size = output_texts.size();
//     for (int i=1; i<=size; i++) { //出力画像数だけ名付ける
//         std::ostringstream oss;
//         oss << date << "_" <<i;//ex:201908222230_
//         std::cout << oss.str() + ".txt" << std::endl;//ex:201908222230.jpg
//         std::ofstream outputfile(oss.str() + ".txt");
//         outputfile << output_texts[i-1] << std::endl;
//         outputfile.close();
//     }
// }
