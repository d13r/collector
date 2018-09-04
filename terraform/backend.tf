# Store state on S3 so it can be shared between different computers
terraform {
  backend "s3" {
    bucket  = "davejamesmiller-terraform"
    key     = "collector/terraform.tfstate"
    region  = "eu-west-1"
  }
}
