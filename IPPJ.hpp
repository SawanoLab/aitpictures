#include <iostream>  //入出力関連ヘッダ
#include <opencv2/opencv.hpp>  //OpenCV関連ヘッダ

std::vector <cv::Mat> IPPJInit(int argc, const char *argv[]);//argv（画像名）の画像を読み込む
void IPPJOutputImg(std::vector <cv::Mat> output_imgs);//提出画像の名付け用
// void IPPJOutputText(std::vector <int> output_texts);//提出テキストの名付け用



