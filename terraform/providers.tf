provider "aws" {
  # Credentials are read from ~/.aws/credentials (use "aws configure")
  region  = "eu-west-1"
  version = "~> 1.11"
}

provider "aws" {
  # CloudFront is based in US East (Northern Virginia)
  alias   = "global"
  region  = "us-east-1"
  version = "~> 1.11"
}
