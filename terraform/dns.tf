#---------------------------------------
# Zone (already exists)
#---------------------------------------

data "aws_route53_zone" "davejamesmiller_com" {
  name = "davejamesmiller.com."
  private_zone = false
}

#---------------------------------------
# Records
#---------------------------------------

resource "aws_route53_record" "collector_davejamesmiller_com" {
  zone_id = "${data.aws_route53_zone.davejamesmiller_com.zone_id}"
  name    = "collector.davejamesmiller.com"
  type    = "CNAME"
  ttl     = 1800
  records = ["7of9.djm.me"]
}
